<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Converter;

use EvgenijVY\SimpleMapper\Dto\SourcePropertyDataDto;
use ReflectionProperty;

class StringToDateTimeInterfaceConverter implements ValueConverterInterface
{
    public function convertValue(
        SourcePropertyDataDto $sourcePropertyDataDto,
        ReflectionProperty $reflectionDestinationProperty
    ): mixed
    {
        $type = $reflectionDestinationProperty->getType()->getName();
        return new $type($sourcePropertyDataDto->getValue());
    }
}