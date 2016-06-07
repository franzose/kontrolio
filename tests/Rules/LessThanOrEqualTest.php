<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\LessThanOrEqual;

class LessThanOrEqualTest extends \PHPUnit_Framework_TestCase
{
    public function testValidation()
    {
        $this->assertTrue((new LessThanOrEqual(5))->isValid(5));
        $this->assertFalse((new LessThanOrEqual(5))->isValid(10));
        $this->assertTrue((new LessThanOrEqual(5))->isValid(0));
        $this->assertTrue((new LessThanOrEqual('a'))->isValid('a'));
        $this->assertFalse((new LessThanOrEqual('a'))->isValid('f'));
        $this->assertTrue((new LessThanOrEqual('c'))->isValid('a'));
    }
}