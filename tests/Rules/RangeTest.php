<?php

namespace Kontrolio\Tests\Rules;

use DateTime;
use Kontrolio\Rules\Core\Range;

class RangeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     */
    public function testThrowsWhenMinAndMaxAreNull()
    {
        new Range;
    }

    /**
     * @expectedException \LogicException
     */
    public function testThrowsWhenMaxIsLessThanMin()
    {
        new Range(5, 0);
    }

    public function testNumericViolation()
    {
        $rule = new Range(5, 15);

        $this->assertFalse($rule->isValid('foo'));
        $this->assertEquals(['numeric'], $rule->getViolations());
    }

    public function testValidation()
    {
        $this->assertFalse((new Range(5, 15))->isValid(''));
        $this->assertFalse((new Range(5, 15))->isValid(3));
        $this->assertTrue((new Range(3, 15))->isValid(10));

        $rule = new Range(new DateTime, DateTime::createFromFormat('Y-m-d H:i:s', '2130-01-01 00:00:00'));
        $result = $rule->isValid(DateTime::createFromFormat('Y-m-d H:i:s', '2135-01-01 00:00:00'));

        $this->assertFalse($result);
        $this->assertEquals(['max'], $rule->getViolations());

        $rule = new Range(new DateTime, DateTime::createFromFormat('Y-m-d H:i:s', '2130-01-01 00:00:00'));
        $result = $rule->isValid(DateTime::createFromFormat('Y-m-d H:i:s', '1999-01-01 00:00:00'));

        $this->assertFalse($result);
        $this->assertEquals(['min'], $rule->getViolations());

        $rule = new Range(new DateTime, DateTime::createFromFormat('Y-m-d H:i:s', '2130-01-01 00:00:00'));
        $result = $rule->isValid(DateTime::createFromFormat('Y-m-d H:i:s', '2099-01-01 00:00:00'));

        $this->assertTrue($result);
    }
}