<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\Converters;

use DateTimeInterface;
use EvgenijVY\SimpleMapper\Dto\SourcePropertyDataDto;
use ReflectionProperty;

class DateTimeInterfaceToStringConverter implements ValueConverterInterface
{
    public function convertValue(
        SourcePropertyDataDto $sourcePropertyDataDto,
        ReflectionProperty $reflectionDestinationProperty
    ): mixed
    {
        return $sourcePropertyDataDto->getValue()->format(DateTimeInterface::ATOM);
    }
}