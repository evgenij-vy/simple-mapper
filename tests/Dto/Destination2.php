<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\UnitTest\Dto;

use DateTimeImmutable;

class Destination2
{
    private int $prop1;
    private DateTimeImmutable $prop2;

    public function getProp1(): int
    {
        return $this->prop1;
    }

    public function getProp2(): DateTimeImmutable
    {
        return $this->prop2;
    }
}