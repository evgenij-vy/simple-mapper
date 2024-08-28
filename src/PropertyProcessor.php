<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper;

use DateTimeInterface;
use EvgenijVY\SimpleMapper\Converter as Converter;
use EvgenijVY\SimpleMapper\Dto\PropertyMappingRule;
use EvgenijVY\SimpleMapper\Exception\SourcePropertyNotFoundException;
use EvgenijVY\SimpleMapper\Exception\UnsupportedConversionTypeException;
use ReflectionObject;
use ReflectionProperty;

class PropertyProcessor
{
    /**
     * @throws UnsupportedConversionTypeException
     */
    public function process(
        ReflectionProperty          $reflectionDestinationProperty,
        ReflectionObject            $sourceReflection,
        object                      $sourceObject,
        object                      $destinationObject,
        PropertyMappingRule         $propertyMappingRule
    ): void
    {
        try {
            $sourceValue = $propertyMappingRule->getPropertyExtractor()->retrievePropertyData(
                $reflectionDestinationProperty,
                $sourceReflection,
                $sourceObject
            );

            $propertyMappingRule->getValueSetter()->setValue(
                $reflectionDestinationProperty,
                $destinationObject,
                ($propertyMappingRule->getValueConverter() ?? $this->getDefaultValueConverter(
                    ValueService::getRealValueType($sourceValue),
                    $reflectionDestinationProperty->getType()->getName()
                ))->convertValue($sourceValue, $reflectionDestinationProperty)
            );
        } catch (SourcePropertyNotFoundException) {
            return;
        }
    }

    /**
     * @throws UnsupportedConversionTypeException
     */
    private function getDefaultValueConverter(
        string $sourceTypeName,
        string $destinationTypeName
    ): Converter\ValueConverterInterface
    {
        if ($sourceTypeName !== $destinationTypeName && 'mixed' !== $destinationTypeName) {
            if (is_a($sourceTypeName, DateTimeInterface::class, true)) {
                return match ($destinationTypeName) {
                    'string' => new Converter\DateTimeInterfaceToStringConverter(),
                    'integer', 'float' => new Converter\DateTimeInterfaceToNumberConverter(),
                    default => throw new UnsupportedConversionTypeException()
                };
            }

            if (is_a($destinationTypeName, DateTimeInterface::class, true)) {
                return match ($sourceTypeName) {
                    'string' => new Converter\StringToDateTimeInterfaceConverter(),
                    'integer', 'float' => new Converter\NumericToDateTimeInterfaceConverter(),
                    default => throw new UnsupportedConversionTypeException()
                };
            }
        }

        return new Converter\NoConverter();
    }
}