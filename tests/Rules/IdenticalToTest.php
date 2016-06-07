<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\IdenticalTo;

class IdenticalToTest extends \PHPUnit_Framework_TestCase
{
    public function testValidation()
    {
        $this->assertTrue((new IdenticalTo(5))->isValid(5));
        $this->assertFalse((new IdenticalTo(5))->isValid('5'));
        $this->assertTrue((new IdenticalTo('a'))->isValid('a'));
        $this->assertFalse((new IdenticalTo('a'))->isValid('b'));
    }
}