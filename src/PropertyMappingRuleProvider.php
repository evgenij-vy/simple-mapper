<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper;

use EvgenijVY\SimpleMapper\Attributes\MapFrom;
use EvgenijVY\SimpleMapper\Attributes\MappingAttributeInterface;
use EvgenijVY\SimpleMapper\Attributes\MapTo;
use EvgenijVY\SimpleMapper\Dto\PropertyMappingRule;
use EvgenijVY\SimpleMapper\Exception\MultipleMappingException;
use ReflectionAttribute;
use ReflectionClass;
use ReflectionObject;

class PropertyMappingRuleProvider
{
    private array $rules = [];

    public function __construct(
        private readonly ReflectionClass  $destinationReflectionClass,
        private readonly ReflectionObject $sourceData,
    )
    {
        $destinationReflectionClassName = $destinationReflectionClass->getName();
        $sourceDataClassName = $sourceData->getName();


        /** @var MappingAttributeInterface[] $mappingAttributes */
        $mappingAttributes = array_merge(
            array_filter(
                $this->getAttributes(MapFrom::class, $this->destinationReflectionClass),
                function (MapFrom $attribute) use ($sourceDataClassName) {
                    return $attribute->getSourceClassName() === $sourceDataClassName;
                }
            ),
            array_filter(
                $this->getAttributes(MapTo::class, $this->sourceData),
                function (MapTo $attribute) use ($destinationReflectionClassName) {
                    return $attribute->getDestinationClassName() === $destinationReflectionClassName;
                }
            )
        );

        switch (count($mappingAttributes)) {
            case 0:
                break;
            case 1:
                foreach ($mappingAttributes[0]->getPropertyMappingRules() as $propertyMappingRule) {
                    $this->rules[$propertyMappingRule->getDestinationPropertyName()] = $propertyMappingRule;
                }
                break;
            default:
                throw new MultipleMappingException();
        }
    }

    public function getPropertyRule(string $propertyName): PropertyMappingRule
    {
        return $this->rules[$propertyName] ?? new PropertyMappingRule($propertyName);
    }

    /**
     * @template T
     * @param class-string<T> $attributeClass
     * @return T[]
     */
    private function getAttributes(string $attributeClass, ReflectionClass $class): array
    {
        return array_map(
            fn (ReflectionAttribute $attribute) => $attribute->newInstance(),
            $class->getAttributes($attributeClass)
        );
    }
}