<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\UnitTest\Dto;

class Source1
{
    private string $name;

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}