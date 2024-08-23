<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Converters;

use EvgenijVY\SimpleMapper\Dto\SourcePropertyDataDto;
use ReflectionProperty;

class NumericToDateTimeInterfaceConverter implements ValueConverterInterface
{
    public function convertValue(
        SourcePropertyDataDto $sourcePropertyDataDto,
        ReflectionProperty $reflectionDestinationProperty
    ): mixed
    {
        $type = $reflectionDestinationProperty->getType()->getName();
        return (new $type())->setTimestamp((int) $sourcePropertyDataDto->getValue());
    }
}