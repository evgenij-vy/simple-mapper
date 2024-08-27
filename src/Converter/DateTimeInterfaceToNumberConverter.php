<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Converter;

use DateTimeInterface;
use EvgenijVY\SimpleMapper\Exception\UnsupportedConversionTypeException;
use ReflectionProperty;

class DateTimeInterfaceToNumberConverter implements ValueConverterInterface
{
    /**
     * @throws UnsupportedConversionTypeException
     */
    public function convertValue(mixed $sourceValue, ReflectionProperty $reflectionDestinationProperty): int
    {
        if (!$sourceValue instanceof DateTimeInterface) {
            throw new UnsupportedConversionTypeException();
        }

        return $sourceValue->getTimestamp();
    }
}