<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\Blank;
use PHPUnit\Framework\TestCase;

class BlankTest extends TestCase
{
    public function testValidation()
    {
        $rule = new Blank;

        static::assertFalse($rule->isValid('foo'));
        static::assertTrue($rule->isValid(''));
        static::assertTrue($rule->isValid());
    }
}