<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\DateTime;
use PHPUnit\Framework\TestCase;

class DateTimeTest extends TestCase
{
    public function testBasicValidation()
    {
        static::assertTrue((new DateTime)->isValid('2016-06-06 23:59:59'));
    }

    public function testGeneralFormatViolation()
    {
        $rule = new DateTime;

        static::assertFalse($rule->isValid('foo'));
        static::assertEquals(['format'], $rule->getViolations());
    }

    public function testWarningViolations()
    {
        $one = new DateTime;
        $two = new DateTime;

        static::assertFalse($one->isValid('0000-00-00 23:59:59'));
        static::assertFalse($two->isValid('2016-06-06 99:88:77'));
        static::assertEquals(['date'], $one->getViolations());
        static::assertEquals(['time'], $two->getViolations());
    }
}