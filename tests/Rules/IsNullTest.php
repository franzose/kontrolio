<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\IsNull;
use PHPUnit\Framework\TestCase;

class IsNullTest extends TestCase
{
    public function testValidation()
    {
        $rule = new IsNull;

        $this->assertFalse($rule->isValid('foo'));
        $this->assertFalse($rule->isValid(''));
        $this->assertTrue($rule->isValid());
    }
}