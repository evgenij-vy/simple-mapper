<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper;

use DateTimeInterface;
use EvgenijVY\SimpleMapper\Converters\DateTimeInterfaceToNumberConverter;
use EvgenijVY\SimpleMapper\Converters\DateTimeInterfaceToStringConverter;
use EvgenijVY\SimpleMapper\Converters\NoConverter;
use EvgenijVY\SimpleMapper\Converters\NumericToDateTimeInterfaceConverter;
use EvgenijVY\SimpleMapper\Converters\StringToDateTimeInterfaceConverter;
use EvgenijVY\SimpleMapper\Converters\ValueConverterInterface;
use EvgenijVY\SimpleMapper\Dto\SourcePropertyDataDto;
use EvgenijVY\SimpleMapper\Exception\SourcePropertyNotFoundException;
use EvgenijVY\SimpleMapper\Exception\UnsupportedConversionTypeException;
use EvgenijVY\SimpleMapper\Extractors\PropertyExtractorInterface;
use EvgenijVY\SimpleMapper\Extractors\ReflectionPropertyExtractor;
use ReflectionObject;
use ReflectionProperty;

class PropertyProcessor
{
    /**
     * @throws UnsupportedConversionTypeException
     */
    public function process(
        ReflectionProperty $reflectionDestinationProperty,
        ReflectionObject   $sourceReflection,
        object             $sourceObject,
        object             $destinationObject,
    ): void
    {
        try {
            $this->setValueToDestinationObject(
                $reflectionDestinationProperty,
                $destinationObject,
                $this->convertValue(
                    $this->getPropertyExtractor()->retrievePropertyData(
                        $reflectionDestinationProperty,
                        $sourceReflection,
                        $sourceObject
                    ),
                    $reflectionDestinationProperty
                )
            );
        } catch (SourcePropertyNotFoundException) {
            return;
        }
    }

    private function getPropertyExtractor(): PropertyExtractorInterface
    {
        return new ReflectionPropertyExtractor();
    }

    /**
     * @throws UnsupportedConversionTypeException
     */
    private function getValueConverter(string $sourceTypeName, string $destinationTypeName): ValueConverterInterface
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

    /**
     * @throws UnsupportedConversionTypeException
     */
    private function convertValue(
        SourcePropertyDataDto $sourcePropertyDataDto,
        ReflectionProperty $reflectionDestinationProperty
    ): mixed
    {
        return $this
            ->getValueConverter(
                $sourcePropertyDataDto->getProperty()->getType()->getName(),
                $reflectionDestinationProperty->getType()->getName()
            )
            ->convertValue($sourcePropertyDataDto, $reflectionDestinationProperty);
    }

    private function setValueToDestinationObject(
        ReflectionProperty $reflectionDestinationProperty,
        object             $destinationObject,
        mixed              $value
    ): void
    {
        $reflectionDestinationProperty->setValue($destinationObject, $value);
    }
}