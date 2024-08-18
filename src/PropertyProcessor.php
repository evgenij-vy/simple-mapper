<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper;

use EvgenijVY\SimpleMapper\Exception\SourcePropertyNotFoundException;
use ReflectionObject;
use ReflectionProperty;
use ReflectionException;

class PropertyProcessor
{
    public function process(
        ReflectionProperty $reflectionDestinationProperty,
        ReflectionObject   $sourceReflection,
        object             $sourceObject,
        object             $destinationObject,
    ): void
    {
        try {
            $this->setValueToDestinationObject(
                $reflectionDestinationProperty,
                $destinationObject,
                $this->convertValue(
                    $this->retrieveSourcePropertyValue(
                        $reflectionDestinationProperty,
                        $sourceReflection,
                        $sourceObject
                    )
                )
            );
        } catch (SourcePropertyNotFoundException) {
            return;
        }
    }

    /**
     * @throws SourcePropertyNotFoundException
     */
    private function retrieveSourcePropertyValue(
        ReflectionProperty $reflectionDestinationProperty,
        ReflectionObject   $sourceReflection,
        object             $sourceObject,
    ): mixed
    {
        try {
            return $sourceReflection->getProperty($reflectionDestinationProperty->getName())->getValue($sourceObject);
        } catch (ReflectionException) {
            throw new SourcePropertyNotFoundException();
        }
    }

    private function convertValue(mixed $value): mixed
    {
        return $value;
    }

    private function setValueToDestinationObject(
        ReflectionProperty $reflectionDestinationProperty,
        object             $destinationObject,
        mixed $value
    ): void
    {
        $reflectionDestinationProperty->setValue($destinationObject, $value);
    }
}