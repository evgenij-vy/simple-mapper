<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Converter;

use ReflectionProperty;

class StringToDateTimeInterfaceConverter implements ValueConverterInterface
{
    /**
     * @throws \Exception
     */
    public function convertValue(mixed $sourceValue, ReflectionProperty $reflectionDestinationProperty): mixed
    {
        $type = $reflectionDestinationProperty->getType()->getName();
        return new $type($sourceValue);
    }
}