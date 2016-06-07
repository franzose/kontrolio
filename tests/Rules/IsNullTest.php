<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\IsNull;

class IsNullTest extends \PHPUnit_Framework_TestCase
{
    public function testValidation()
    {
        $rule = new IsNull;

        $this->assertFalse($rule->isValid('foo'));
        $this->assertFalse($rule->isValid(''));
        $this->assertTrue($rule->isValid());
    }
}