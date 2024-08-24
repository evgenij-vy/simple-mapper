<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Setter;

use ReflectionProperty;

class ReflectionSetter implements ValueSetterInterface
{
    public function setValue(
        ReflectionProperty $reflectionDestinationProperty,
        object $destinationObject,
        mixed $value
    ): void
    {
        $reflectionDestinationProperty->setValue($destinationObject, $value);
    }
}