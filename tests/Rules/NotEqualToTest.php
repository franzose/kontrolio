<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\NotEqualTo;
use PHPUnit\Framework\TestCase;

class NotEqualToTest extends TestCase
{
    public function testValidation()
    {
        static::assertFalse((new NotEqualTo(5))->isValid(5));
        static::assertTrue((new NotEqualTo(5))->isValid(6));
        static::assertFalse((new NotEqualTo('a'))->isValid('a'));
        static::assertTrue((new NotEqualTo('a'))->isValid('b'));
    }
}