<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\UnitTest\Dto;

use EvgenijVY\SimpleMapper\Attributes\MapFrom;
use EvgenijVY\SimpleMapper\Converter\DateTimeInterfaceToStringConverter;
use EvgenijVY\SimpleMapper\Dto\PropertyMappingRule;

#[MapFrom(
    Source4::class,
    [
        new PropertyMappingRule('data', valueConverter: new DateTimeInterfaceToStringConverter())
    ]
)]
class Destination4
{
    private string $date;

    public function getDate(): string
    {
        return $this->date;
    }
}