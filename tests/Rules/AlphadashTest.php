<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\Alphadash;
use PHPUnit\Framework\TestCase;

class AlphadashTest extends TestCase
{
    public function testValidation()
    {
        $rule = new Alphadash;

        static::assertFalse($rule->isValid('føó'));
        static::assertFalse($rule->isValid(''));
        static::assertTrue($rule->isValid('foo-_1234'));
        static::assertTrue($rule->isValid('foo-_'));
    }
}