<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\IsTrue;

class IsTrueTest extends \PHPUnit_Framework_TestCase
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