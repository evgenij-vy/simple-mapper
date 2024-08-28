<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Extractor;

use EvgenijVY\SimpleMapper\Exception\SourcePropertyNotFoundException;
use ReflectionException;
use ReflectionObject;
use ReflectionProperty;

class ReflectionPropertyExtractor implements PropertyExtractorInterface
{
    public function retrievePropertyData(
        ReflectionProperty $reflectionDestinationProperty,
        ReflectionObject $sourceReflection,
        object $sourceObject
    ): mixed
    {
        try {
            return $sourceReflection->getProperty($reflectionDestinationProperty->getName())->getValue($sourceObject);
        } catch (ReflectionException) {
            throw new SourcePropertyNotFoundException();
        }
    }
}