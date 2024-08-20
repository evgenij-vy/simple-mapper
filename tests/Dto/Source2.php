<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\UnitTest\Dto;

class Source2
{
    private string $prop1;
    private string $prop2;

    public function setProp1(string $prop1): self
    {
        $this->prop1 = $prop1;

        return $this;
    }

    public function setProp2(string $prop2): self
    {
        $this->prop2 = $prop2;

        return $this;
    }
}