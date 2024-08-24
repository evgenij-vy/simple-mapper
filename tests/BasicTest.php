<?php

declare(strict_types=1);

namespace EvgenijVY\SimpleMapper\UnitTest;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use EvgenijVY\SimpleMapper\Mapper;
use EvgenijVY\SimpleMapper\UnitTest\Dto\Destination1;
use EvgenijVY\SimpleMapper\UnitTest\Dto\Destination2;
use EvgenijVY\SimpleMapper\UnitTest\Dto\Destination3;
use EvgenijVY\SimpleMapper\UnitTest\Dto\Destination4;
use EvgenijVY\SimpleMapper\UnitTest\Dto\Source1;
use EvgenijVY\SimpleMapper\UnitTest\Dto\Source2;
use EvgenijVY\SimpleMapper\UnitTest\Dto\Source3;
use EvgenijVY\SimpleMapper\UnitTest\Dto\Source4;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

class BasicTest extends TestCase
{
    private Mapper $mapper;

    public function __construct(string $name)
    {
        parent::__construct($name);

        $this->mapper = new Mapper();
    }

    #[Test]
    #[TestWith(['test'])]
    public function basic(string $testString): void
    {
        $this->assertEquals(
            $testString,
            $this->mapper->map((new Source1())->setName($testString), Destination1::class)->getName()
        );
    }

    #[Test]
    #[TestWith(['123456', '2024-01-02'])]
    public function typeConverting(string $testIntSting, string $testDateString): void
    {
        $destination = $this->mapper->map(
            (new Source2())->setProp1($testIntSting)->setProp2($testDateString),
            Destination2::class
        );

        $this->assertEquals((int)$testIntSting, $destination->getProp1());
        $this->assertEquals(new DateTimeImmutable($testDateString), $destination->getProp2());
    }

    #[Test]
    #[TestWith([475738, new DateTime('2024-06-12')])]
    public function typeConvertingRevert(int $testInt, DateTime $dateTime): void
    {
        $destination = $this->mapper->map(
            (new Source3())->setProp1($testInt)->setProp2($dateTime),
            Destination3::class
        );

        $this->assertEquals((string)$testInt, $destination->getProp1());
        $this->assertEquals($dateTime->format(DateTimeInterface::ATOM), $destination->getProp2());
    }

    #[Test]
    public function attributeTest(): void
    {
        $this->assertEquals(
            (new DateTimeImmutable())->setTime(0, 0)->format(DateTimeInterface::ATOM),
            $this->mapper->map(new Source4(), Destination4::class)->getDate()
        );
    }
}