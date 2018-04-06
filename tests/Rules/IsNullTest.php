<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\IsNull;
use PHPUnit\Framework\TestCase;

class IsNullTest extends TestCase
{
    public function testValidation()
    {
        $rule = new IsNull;

        static::assertFalse($rule->isValid('foo'));
        static::assertFalse($rule->isValid(''));
        static::assertTrue($rule->isValid());
    }
}