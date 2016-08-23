<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\Alpha;

class AlphaTest extends \PHPUnit_Framework_TestCase
{
    public function testValidation()
    {
        $rule = new Alpha;

        $this->assertFalse($rule->isValid('føó'));
        $this->assertFalse($rule->isValid(''));
        $this->assertFalse($rule->isValid('foo-_1234'));
        $this->assertTrue($rule->isValid('foo'));
    }
}