<?php

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\EqualTo;
use PHPUnit\Framework\TestCase;

class EqualToTest extends TestCase
{
    public function testValidation()
    {
        static::assertTrue((new EqualTo(5))->isValid(5));
        static::assertFalse((new EqualTo(5))->isValid(6));
        static::assertTrue((new EqualTo('a'))->isValid('a'));
        static::assertFalse((new EqualTo('a'))->isValid('b'));
    }
}