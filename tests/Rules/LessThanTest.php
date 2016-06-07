<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\LessThan;

class LessThanTest extends \PHPUnit_Framework_TestCase
{
    public function testValidation()
    {
        $this->assertFalse((new LessThan(5))->isValid(5));
        $this->assertFalse((new LessThan(5))->isValid(10));
        $this->assertTrue((new LessThan(5))->isValid(0));
        $this->assertFalse((new LessThan('a'))->isValid('a'));
        $this->assertFalse((new LessThan('a'))->isValid('f'));
        $this->assertTrue((new LessThan('c'))->isValid('a'));
    }
}