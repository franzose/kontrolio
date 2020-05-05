<?php

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\LessThan;
use PHPUnit\Framework\TestCase;

class LessThanTest extends TestCase
{
    public function testValidation()
    {
        static::assertFalse((new LessThan(5))->isValid(5));
        static::assertFalse((new LessThan(5))->isValid(10));
        static::assertTrue((new LessThan(5))->isValid(0));
        static::assertFalse((new LessThan('a'))->isValid('a'));
        static::assertFalse((new LessThan('a'))->isValid('f'));
        static::assertTrue((new LessThan('c'))->isValid('a'));
    }
}