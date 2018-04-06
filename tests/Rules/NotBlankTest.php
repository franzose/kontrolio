<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\NotBlank;
use PHPUnit\Framework\TestCase;

class NotBlankTest extends TestCase
{
    public function testValidation()
    {
        $rule = new NotBlank;

        $this->assertTrue($rule->isValid('foo'));
        $this->assertFalse($rule->isValid(''));
        $this->assertFalse($rule->isValid());
    }
}