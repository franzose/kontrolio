<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\NotNull;
use PHPUnit\Framework\TestCase;

class NotNullTest extends TestCase
{
    public function testValidation()
    {
        $rule = new NotNull;

        static::assertTrue($rule->isValid('foo'));
        static::assertTrue($rule->isValid(''));
        static::assertFalse($rule->isValid());
    }
}