<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Converter;

use ReflectionProperty;

class NoConverter implements ValueConverterInterface
{
    public function convertValue(mixed $sourceValue, ReflectionProperty $reflectionDestinationProperty): mixed
    {
        return $sourceValue;
    }
}