<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\UnitTest\Dto;

use DateTimeImmutable;

class Source4
{
    private DateTimeImmutable $date;

    public function __construct()
    {
        $this->date = (new DateTimeImmutable())->setTime(0, 0);
    }
}