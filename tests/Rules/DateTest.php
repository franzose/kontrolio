<?php
/**
 * Created by PhpStorm.
 * User: Yan
 * Date: 06.06.16
 * Time: 16:23
 */

namespace Kontrolio\Tests\Rules;


use Kontrolio\Rules\Core\Date;
use PHPUnit\Framework\TestCase;

class DateTest extends TestCase
{
    public function testBasicValidation()
    {
        $rule = new Date;

        static::assertTrue($rule->isValid('2016-06-06'));
    }

    public function testViolations()
    {
        $one = new Date;
        $one->isValid('foo');

        $two = new Date;
        $two->isValid('0000-00-00');

        static::assertEquals(['format'], $one->getViolations());
        static::assertEquals(['date'], $two->getViolations());
    }
}