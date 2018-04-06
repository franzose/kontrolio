<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\IsFalse;
use PHPUnit\Framework\TestCase;

class IsFalseTest extends TestCase
{
    public function testValidation()
    {
        $rule = new IsFalse;

        $this->assertFalse($rule->isValid('foo'));
        $this->assertFalse($rule->isValid(''));
        $this->assertFalse($rule->isValid());
        $this->assertTrue($rule->isValid(false));
    }
}