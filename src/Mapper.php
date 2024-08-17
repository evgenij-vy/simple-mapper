<?php
//

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper;

use ReflectionClass;
use ReflectionException;
use ReflectionObject;

class Mapper
{
    /**
     * @throws ReflectionException
     */
    public function map(object $source, string $destination): object
    {
        $destinationReflectionClass = new ReflectionClass($destination);
        $sourceData = new ReflectionObject($source);
        $destinationObject = $destinationReflectionClass->newInstanceWithoutConstructor();

        foreach ($destinationReflectionClass->getProperties() as $destinationProperty) {
            if ($sourceData->hasProperty($destinationProperty->getName())) {
                $destinationProperty->setValue(
                    $destinationObject,
                    $sourceData->getProperty($destinationProperty->getName())->getValue($source),
                );
            }
        }

        return $destinationObject;
    }
}