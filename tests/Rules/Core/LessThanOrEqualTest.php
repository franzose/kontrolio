<?php

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\LessThanOrEqual;
use PHPUnit\Framework\TestCase;

class LessThanOrEqualTest extends TestCase
{
    public function testValidation()
    {
        static::assertTrue((new LessThanOrEqual(5))->isValid(5));
        static::assertFalse((new LessThanOrEqual(5))->isValid(10));
        static::assertTrue((new LessThanOrEqual(5))->isValid(0));
        static::assertTrue((new LessThanOrEqual('a'))->isValid('a'));
        static::assertFalse((new LessThanOrEqual('a'))->isValid('f'));
        static::assertTrue((new LessThanOrEqual('c'))->isValid('a'));
    }
}