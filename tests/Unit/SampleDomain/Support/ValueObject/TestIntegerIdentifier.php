<?php
declare(strict_types=1);

namespace Tests\Unit\SampleDomain\Support\ValueObject;

use SampleDomain\Support\Exception\InvalidNativeArgumentException;
use Tests\TestCase;
use SampleDomain\Support\ValueObject\IntegerIdentifier;

final class TestIntegerIdentifier extends TestCase
{
    public function testShouldThrowException(): void
    {
        $this->expectException(exception: InvalidNativeArgumentException::class);
        new IntegerIdentifier(0);
    }

    public function testShouldReturnSameValue(): void
    {
        $i = new IntegerIdentifier(1);
        $this->assertSame(1, $i->value());
    }
}
