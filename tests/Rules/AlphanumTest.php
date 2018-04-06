<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\Alphanum;
use PHPUnit\Framework\TestCase;

class AlphanumTest extends TestCase
{
    public function testValidation()
    {
        $rule = new Alphanum;

        static::assertFalse($rule->isValid('føó'));
        static::assertFalse($rule->isValid(''));
        static::assertFalse($rule->isValid('foo-_1234'));
        static::assertTrue($rule->isValid('foo1234'));
    }
}