<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Attributes;

use Attribute;
use EvgenijVY\SimpleMapper\Dto\PropertyMappingRule;

#[Attribute(Attribute::TARGET_CLASS)]
class MapTo
{
    /**
     * @param class-string $targetClassName
     * @param PropertyMappingRule[] $propertyMappingRules
     */
    public function __construct(
        private readonly string $targetClassName,
        private readonly array  $propertyMappingRules = [],
    )
    {
    }

    public function getTargetClassName(): string
    {
        return $this->targetClassName;
    }

    public function getPropertyMappingRules(): array
    {
        return $this->propertyMappingRules;
    }
}