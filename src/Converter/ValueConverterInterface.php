<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Converter;

use EvgenijVY\SimpleMapper\Dto\SourcePropertyDataDto;
use ReflectionProperty;

interface ValueConverterInterface
{
    public function convertValue(
        SourcePropertyDataDto $sourcePropertyDataDto,
        ReflectionProperty $reflectionDestinationProperty
    ): mixed;
}