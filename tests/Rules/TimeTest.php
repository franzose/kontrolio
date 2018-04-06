<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\Time;
use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{
    public function testBasicValidation()
    {
        $this->assertTrue((new Time)->isValid('23:59:59'));
    }

    public function testGeneralFormatViolation()
    {
        $rule = new Time;

        $this->assertFalse($rule->isValid('foo'));
        $this->assertEquals(['format'], $rule->getViolations());
    }

    public function testWarningViolations()
    {
        $rule = new Time;
        
        $this->assertFalse($rule->isValid('99:88:77'));
        $this->assertEquals(['time'], $rule->getViolations());
    }
}