<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Converter;

use EvgenijVY\SimpleMapper\Dto\SourcePropertyDataDto;
use ReflectionProperty;

class NoConverter implements ValueConverterInterface
{

    public function convertValue(
        SourcePropertyDataDto $sourcePropertyDataDto,
        ReflectionProperty $reflectionDestinationProperty
    ): mixed
    {
        return $sourcePropertyDataDto->getValue();
    }
}