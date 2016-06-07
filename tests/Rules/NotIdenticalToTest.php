<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\NotIdenticalTo;

class NotIdenticalToTest extends \PHPUnit_Framework_TestCase
{
    public function testValidation()
    {
        $this->assertFalse((new NotIdenticalTo(5))->isValid(5));
        $this->assertTrue((new NotIdenticalTo(5))->isValid('5'));
        $this->assertFalse((new NotIdenticalTo('a'))->isValid('a'));
        $this->assertTrue((new NotIdenticalTo('a'))->isValid('b'));
    }
}