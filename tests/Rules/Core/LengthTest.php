<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\Length;
use PHPUnit\Framework\TestCase;

class LengthTest extends TestCase
{
    public function testThrowsWhenMinAndMaxAreNull(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new Length;
    }

    public function testThrowsWhenMaxIsLessThanMin(): void
    {
        $this->expectException(\LogicException::class);

        new Length(5, 0);
    }

    public function testValidation(): void
    {
        static::assertFalse((new Length(5, 15))->isValid(''));
        static::assertFalse((new Length(5, 15))->isValid('test'));
        static::assertTrue((new Length(3, 15))->isValid('foo'));
    }
}