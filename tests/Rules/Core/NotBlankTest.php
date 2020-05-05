<?php

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\NotBlank;
use PHPUnit\Framework\TestCase;

class NotBlankTest extends TestCase
{
    public function testValidation()
    {
        $rule = new NotBlank;

        static::assertTrue($rule->isValid('foo'));
        static::assertFalse($rule->isValid(''));
        static::assertFalse($rule->isValid());
    }
}