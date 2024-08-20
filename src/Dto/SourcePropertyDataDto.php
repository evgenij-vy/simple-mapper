<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Dto;

use ReflectionProperty;

final class SourcePropertyDataDto
{
    public function __construct(
        private readonly mixed              $value,
        private readonly ReflectionProperty $property,
    )
    {
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getProperty(): ReflectionProperty
    {
        return $this->property;
    }
}