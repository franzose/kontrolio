<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\DateTime;

class DateTimeTest extends \PHPUnit_Framework_TestCase
{
    public function testBasicValidation()
    {
        $this->assertTrue((new DateTime)->isValid('2016-06-06 23:59:59'));
    }

    public function testGeneralFormatViolation()
    {
        $rule = new DateTime;

        $this->assertFalse($rule->isValid('foo'));
        $this->assertEquals(['format'], $rule->getViolations());
    }

    public function testWarningViolations()
    {
        $one = new DateTime;
        $two = new DateTime;

        $this->assertFalse($one->isValid('0000-00-00 23:59:59'));
        $this->assertFalse($two->isValid('2016-06-06 99:88:77'));
        $this->assertEquals(['date'], $one->getViolations());
        $this->assertEquals(['time'], $two->getViolations());
    }
}