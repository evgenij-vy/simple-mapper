<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Extractor;

use EvgenijVY\SimpleMapper\Dto\SourcePropertyDataDto;
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
    ): SourcePropertyDataDto
    {
        try {
            $sourceReflectionProperty = $sourceReflection->getProperty($reflectionDestinationProperty->getName());

            return new SourcePropertyDataDto(
                $sourceReflectionProperty->getValue($sourceObject),
                $sourceReflectionProperty
            );
        } catch (ReflectionException) {
            throw new SourcePropertyNotFoundException();
        }
    }
}