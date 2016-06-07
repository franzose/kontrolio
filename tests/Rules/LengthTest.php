<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\Length;

class LengthTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsWhenMinAndMaxAreNull()
    {
        new Length;
    }

    /**
     * @expectedException \LogicException
     */
    public function testThrowsWhenMaxIsLessThanMin()
    {
        new Length(5, 0);
    }

    public function testValidation()
    {
        $this->assertFalse((new Length(5, 15))->isValid(''));
        $this->assertFalse((new Length(5, 15))->isValid('test'));
        $this->assertTrue((new Length(3, 15))->isValid('foo'));
    }
}