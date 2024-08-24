<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper;

use EvgenijVY\SimpleMapper\Exception\MultipleMappingException;
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
     * @param class-string<T> $destination
     * @return T
     * @throws ReflectionException
     * @throws UnsupportedConversionTypeException
     * @throws MultipleMappingException
     */
    public function map(object $source, string $destination): object
    {
        $destinationReflectionClass = new ReflectionClass($destination);
        $sourceData = new ReflectionObject($source);
        $destinationObject = $destinationReflectionClass->newInstanceWithoutConstructor();
        $propertyMappingRuleProvider = new PropertyMappingRuleProvider($destinationReflectionClass, $sourceData);

        foreach ($destinationReflectionClass->getProperties() as $destinationProperty) {
            $this->propertyProcessor->process(
                $destinationProperty,
                $sourceData,
                $source,
                $destinationObject,
                $propertyMappingRuleProvider->getPropertyRule($destinationProperty->getName())
            );
        }

        return $destinationObject;
    }
}