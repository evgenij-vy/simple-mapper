<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Converters;

use EvgenijVY\SimpleMapper\Dto\SourcePropertyDataDto;
use ReflectionProperty;

interface ValueConverterInterface
{
    public function convertValue(
        SourcePropertyDataDto $sourcePropertyDataDto,
        ReflectionProperty $reflectionDestinationProperty
    ): mixed;
}