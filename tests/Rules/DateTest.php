<?php
/**
 * Created by PhpStorm.
 * User: Yan
 * Date: 06.06.16
 * Time: 16:23
 */

namespace Kontrolio\Tests\Rules;


use Kontrolio\Rules\Core\Date;

class DateTest extends \PHPUnit_Framework_TestCase
{
    public function testBasicValidation()
    {
        $rule = new Date;

        $this->assertTrue($rule->isValid('2016-06-06'));
    }

    public function testViolations()
    {
        $one = new Date;
        $one->isValid('foo');

        $two = new Date;
        $two->isValid('0000-00-00');

        $this->assertEquals(['format'], $one->getViolations());
        $this->assertEquals(['date'], $two->getViolations());
    }
}