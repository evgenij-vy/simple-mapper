<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Setter;

use ReflectionProperty;

interface ValueSetterInterface
{
    public function setValue(
        ReflectionProperty $reflectionDestinationProperty,
        object             $destinationObject,
        mixed              $value
    ): void;
}