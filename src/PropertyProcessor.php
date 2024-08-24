<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper;

use DateTimeInterface;
use EvgenijVY\SimpleMapper\Converter\DateTimeInterfaceToNumberConverter;
use EvgenijVY\SimpleMapper\Converter\DateTimeInterfaceToStringConverter;
use EvgenijVY\SimpleMapper\Converter\NoConverter;
use EvgenijVY\SimpleMapper\Converter\NumericToDateTimeInterfaceConverter;
use EvgenijVY\SimpleMapper\Converter\StringToDateTimeInterfaceConverter;
use EvgenijVY\SimpleMapper\Converter\ValueConverterInterface;
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
            $sourcePropertyDataDto = $propertyMappingRule->getPropertyExtractor()->retrievePropertyData(
                $reflectionDestinationProperty,
                $sourceReflection,
                $sourceObject
            );

            $propertyMappingRule->getValueSetter()->setValue(
                $reflectionDestinationProperty,
                $destinationObject,
                ($propertyMappingRule->getValueConverter() ?? $this->getDefaultValueConverter(
                    $sourcePropertyDataDto->getProperty()->getType()->getName(),
                    $reflectionDestinationProperty->getType()->getName()
                ))->convertValue($sourcePropertyDataDto, $reflectionDestinationProperty)
            );
        } catch (SourcePropertyNotFoundException) {
            return;
        }
    }

    /**
     * @throws UnsupportedConversionTypeException
     */
    private function getDefaultValueConverter(string $sourceTypeName, string $destinationTypeName): ValueConverterInterface
    {
        if ($sourceTypeName !== $destinationTypeName) {
            if (is_a($sourceTypeName, DateTimeInterface::class, true)) {
                return match ($destinationTypeName) {
                    'string' => new DateTimeInterfaceToStringConverter(),
                    'integer', 'float' => new DateTimeInterfaceToNumberConverter(),
                    default => throw new UnsupportedConversionTypeException()
                };
            }

            if (is_a($destinationTypeName, DateTimeInterface::class, true)) {
                return match ($sourceTypeName) {
                    'string' => new StringToDateTimeInterfaceConverter(),
                    'integer', 'float' => new NumericToDateTimeInterfaceConverter(),
                    default => throw new UnsupportedConversionTypeException()
                };
            }
        }

        return new NoConverter();
    }
}