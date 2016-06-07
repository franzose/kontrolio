<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\GreaterThan;

class GreaterThanTest extends \PHPUnit_Framework_TestCase
{
    public function testValidation()
    {
        $this->assertFalse((new GreaterThan(5))->isValid(5));
        $this->assertTrue((new GreaterThan(5))->isValid(10));
        $this->assertFalse((new GreaterThan(5))->isValid(0));
        $this->assertFalse((new GreaterThan('a'))->isValid('a'));
        $this->assertTrue((new GreaterThan('a'))->isValid('f'));
        $this->assertFalse((new GreaterThan('c'))->isValid('a'));
    }
}