<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Attributes;

use EvgenijVY\SimpleMapper\Dto\PropertyMappingRule;

interface MappingAttributeInterface
{
    /**
     * @return PropertyMappingRule[]
     */
    public function getPropertyMappingRules(): array;
}