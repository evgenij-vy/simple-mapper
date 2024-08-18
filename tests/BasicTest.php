<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\UnitTest;

use EvgenijVY\SimpleMapper\Mapper;
use EvgenijVY\SimpleMapper\UnitTest\Dto\DestinationDto;
use EvgenijVY\SimpleMapper\UnitTest\Dto\SourceDto;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class BasicTest extends TestCase
{
    const TEST_STRING = 'test';

    #[Test]
    public function basic(): void
    {
        $this->assertEquals(
            self::TEST_STRING,
            (new Mapper())->map((new SourceDto())->setName(self::TEST_STRING), DestinationDto::class)->getName()
        );
        $this->assertTrue(false);
    }
}