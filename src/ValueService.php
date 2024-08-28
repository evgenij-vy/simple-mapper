<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper;

class ValueService
{
    static public function getRealValueType(mixed $value): string
    {
        return is_object($value) ? get_class($value) : gettype($value);
    }
}