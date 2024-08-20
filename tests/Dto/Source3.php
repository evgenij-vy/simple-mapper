<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\UnitTest\Dto;

use DateTime;

class Source3
{
    private int $prop1;
    private DateTime $prop2;

    public function setProp1(int $prop1): self
    {
        $this->prop1 = $prop1;

        return $this;
    }

    public function setProp2(DateTime $prop2): self
    {
        $this->prop2 = $prop2;

        return $this;
    }
}