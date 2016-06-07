<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\Blank;

class BlankTest extends \PHPUnit_Framework_TestCase
{
    public function testValidation()
    {
        $rule = new Blank;

        $this->assertFalse($rule->isValid('foo'));
        $this->assertTrue($rule->isValid(''));
        $this->assertTrue($rule->isValid());
    }
}