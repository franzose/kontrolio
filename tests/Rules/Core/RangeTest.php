<?php

namespace Kontrolio\Tests\Rules\Core;

use DateTime;
use Kontrolio\Rules\Core\Range;
use PHPUnit\Framework\TestCase;

class RangeTest extends TestCase
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

        static::assertFalse($rule->isValid('foo'));
        static::assertEquals(['numeric'], $rule->getViolations());
    }

    public function testValidation()
    {
        static::assertFalse((new Range(5, 15))->isValid(''));
        static::assertFalse((new Range(5, 15))->isValid(3));
        static::assertTrue((new Range(3, 15))->isValid(10));

        $rule = new Range(new DateTime, DateTime::createFromFormat('Y-m-d H:i:s', '2130-01-01 00:00:00'));
        $result = $rule->isValid(DateTime::createFromFormat('Y-m-d H:i:s', '2135-01-01 00:00:00'));

        static::assertFalse($result);
        static::assertEquals(['max'], $rule->getViolations());

        $rule = new Range(new DateTime, DateTime::createFromFormat('Y-m-d H:i:s', '2130-01-01 00:00:00'));
        $result = $rule->isValid(DateTime::createFromFormat('Y-m-d H:i:s', '1999-01-01 00:00:00'));

        static::assertFalse($result);
        static::assertEquals(['min'], $rule->getViolations());

        $rule = new Range(new DateTime, DateTime::createFromFormat('Y-m-d H:i:s', '2130-01-01 00:00:00'));
        $result = $rule->isValid(DateTime::createFromFormat('Y-m-d H:i:s', '2099-01-01 00:00:00'));

        static::assertTrue($result);
    }
}