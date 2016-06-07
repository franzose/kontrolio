<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\EqualTo;

class EqualToTest extends \PHPUnit_Framework_TestCase
{
    public function testValidation()
    {
        $this->assertTrue((new EqualTo(5))->isValid(5));
        $this->assertFalse((new EqualTo(5))->isValid(6));
        $this->assertTrue((new EqualTo('a'))->isValid('a'));
        $this->assertFalse((new EqualTo('a'))->isValid('b'));
    }
}