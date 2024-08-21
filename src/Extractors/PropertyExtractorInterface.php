<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Extractors;

use EvgenijVY\SimpleMapper\Dto\SourcePropertyDataDto;
use EvgenijVY\SimpleMapper\Exception\SourcePropertyNotFoundException;
use ReflectionObject;
use ReflectionProperty;

interface PropertyExtractorInterface
{
    /**
     * @throws SourcePropertyNotFoundException
     */
    public function retrievePropertyData(
        ReflectionProperty $reflectionDestinationProperty,
        ReflectionObject   $sourceReflection,
        object             $sourceObject
    ): SourcePropertyDataDto;
}