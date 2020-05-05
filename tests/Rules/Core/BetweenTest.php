<?php

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\Between;
use PHPUnit\Framework\TestCase;

final class BetweenTest extends TestCase
{
    public function testValidation()
    {
        static::assertTrue((new Between(5, 10))->isValid(6));
        static::assertFalse((new Between(5, 10))->isValid(5));
        static::assertFalse((new Between(5, 10))->isValid(4));
        static::assertFalse((new Between(5, 10))->isValid(10));
        static::assertFalse((new Between(5, 10))->isValid(11));
        static::assertTrue((new Between('a', 'm'))->isValid('c'));
        static::assertFalse((new Between('a', 'm'))->isValid('a'));
        static::assertFalse((new Between('a', 'm'))->isValid('m'));
        static::assertFalse((new Between('a', 'm'))->isValid('p'));
    }
}
