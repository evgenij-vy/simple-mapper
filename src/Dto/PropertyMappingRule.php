<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Dto;

use EvgenijVY\SimpleMapper\Converter\ValueConverterInterface;
use EvgenijVY\SimpleMapper\Extractor\PropertyExtractorInterface;
use EvgenijVY\SimpleMapper\Extractor\ReflectionPropertyExtractor;
use EvgenijVY\SimpleMapper\Setter\ReflectionSetter;
use EvgenijVY\SimpleMapper\Setter\ValueSetterInterface;

class PropertyMappingRule
{
    public function __construct(
        private readonly string $destinationPropertyName,
        private readonly PropertyExtractorInterface $propertyExtractor = new ReflectionPropertyExtractor(),
        private readonly ?ValueConverterInterface   $valueConverter = null,
        private readonly ValueSetterInterface       $valueSetter = new ReflectionSetter(),
    ) {
    }

    public function getDestinationPropertyName(): string
    {
        return $this->destinationPropertyName;
    }

    public function getPropertyExtractor(): PropertyExtractorInterface
    {
        return $this->propertyExtractor;
    }

    public function getValueConverter(): ?ValueConverterInterface
    {
        return $this->valueConverter;
    }

    public function getValueSetter(): ValueSetterInterface
    {
        return $this->valueSetter;
    }
}