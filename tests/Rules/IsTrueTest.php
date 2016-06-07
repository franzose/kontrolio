<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\IsFalse;

class IsFalseTest extends \PHPUnit_Framework_TestCase
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