<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Converter;

use DateTimeInterface;
use EvgenijVY\SimpleMapper\Exception\UnsupportedConversionTypeException;
use ReflectionProperty;

class NumericToDateTimeInterfaceConverter implements ValueConverterInterface
{
    /**
     * @throws UnsupportedConversionTypeException
     */
    public function convertValue(mixed $sourceValue, ReflectionProperty $reflectionDestinationProperty): mixed
    {
        $type = $reflectionDestinationProperty->getType()->getName();
        if (!is_numeric($sourceValue) || !is_a($type, DateTimeInterface::class, true)) {
            throw new UnsupportedConversionTypeException();
        }

        return (new $type())->setTimestamp((int)$sourceValue);
    }
}