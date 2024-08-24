<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper;

use EvgenijVY\SimpleMapper\Dto\PropertyMappingRule;
use EvgenijVY\SimpleMapper\Exception\UnsupportedConversionTypeException;
use ReflectionClass;
use ReflectionException;
use ReflectionObject;

class Mapper
{
    private PropertyProcessor $propertyProcessor;

    final public function __construct()
    {
        $this->propertyProcessor = new PropertyProcessor();
    }

    /**
     * @template T
     * @param object $source
     * @param class-string<T> $destination
     * @return T
     * @throws ReflectionException
     * @throws UnsupportedConversionTypeException
     */
    public function map(object $source, string $destination): object
    {
        $destinationReflectionClass = new ReflectionClass($destination);
        $sourceData = new ReflectionObject($source);
        $destinationObject = $destinationReflectionClass->newInstanceWithoutConstructor();

        foreach ($destinationReflectionClass->getProperties() as $destinationProperty) {
            $this->propertyProcessor->process($destinationProperty, $sourceData, $source, $destinationObject);
        }

        return $destinationObject;
    }

    /**
     * @return array<string, PropertyMappingRule>
     */
    private function findMappingRulesFromAttribute(ReflectionClass $destinationReflectionClass, ReflectionObject $sourceData): array
    {
        return [];
    }
}