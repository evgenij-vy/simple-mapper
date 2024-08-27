<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Converter;

use ReflectionProperty;

interface ValueConverterInterface
{
    public function convertValue(mixed $sourceValue, ReflectionProperty $reflectionDestinationProperty): mixed;
}