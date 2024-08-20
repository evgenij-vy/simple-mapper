<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\UnitTest\Dto;

class Destination1
{
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }
}