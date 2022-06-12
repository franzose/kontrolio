<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\Time;
use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{
    public function testBasicValidation()
    {
        static::assertTrue((new Time)->isValid('23:59:59'));
    }

    public function testGeneralFormatViolation()
    {
        $rule = new Time;

        static::assertFalse($rule->isValid('foo'));
        static::assertEquals(['format'], $rule->getViolations());
    }

    public function testWarningViolations()
    {
        $rule = new Time;
        
        static::assertFalse($rule->isValid('99:88:77'));
        static::assertEquals(['time'], $rule->getViolations());
    }
}