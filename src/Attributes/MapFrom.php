<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Attributes;

use Attribute;
use EvgenijVY\SimpleMapper\Dto\PropertyMappingRule;

#[Attribute(Attribute::TARGET_CLASS)]
class MapFrom implements MappingAttributeInterface
{
    /**
     * @param class-string $sourceClassName
     * @param PropertyMappingRule[] $propertyMappingRules
     */
    public function __construct(
        private readonly string $sourceClassName,
        private readonly array  $propertyMappingRules = [],
    )
    {
    }

    public function getSourceClassName(): string
    {
        return $this->sourceClassName;
    }

    public function getPropertyMappingRules(): array
    {
        return $this->propertyMappingRules;
    }
}