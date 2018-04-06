<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\IsTrue;
use PHPUnit\Framework\TestCase;

class IsTrueTest extends TestCase
{
    public function testValidation()
    {
        $rule = new IsTrue;
        
        $this->assertFalse($rule->isValid('foo'));
        $this->assertFalse($rule->isValid(''));
        $this->assertFalse($rule->isValid());
        $this->assertTrue($rule->isValid(true));
    }
}