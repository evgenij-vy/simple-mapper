<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Attributes;

use Attribute;
use EvgenijVY\SimpleMapper\Dto\PropertyMappingRule;

#[Attribute(Attribute::TARGET_CLASS)]
class MapTo implements MappingAttributeInterface
{
    /**
     * @param class-string $destinationClassName
     * @param PropertyMappingRule[] $propertyMappingRules
     */
    public function __construct(
        private readonly string $destinationClassName,
        private readonly array  $propertyMappingRules = [],
    )
    {
    }

    public function getDestinationClassName(): string
    {
        return $this->destinationClassName;
    }

    public function getPropertyMappingRules(): array
    {
        return $this->propertyMappingRules;
    }
}