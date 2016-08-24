<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\IsIn;

/**
 * Class IsInTest
 * @package Kontrolio\Tests\Rules
 * @author maximkou <maximkou@gmail.com>
 */
class IsInTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @param array $haystack
     * @param $input
     * @param $expectedResult
     * @param bool $strict
     * @dataProvider dpValidation
     */
    public function testValidation(array $haystack, $strict, $input, $expectedResult)
    {
        $rule = new IsIn($haystack, $strict);

        $this->assertEquals(
            $expectedResult,
            $rule->isValid($input)
        );
    }

    /**
     * @return array
     */
    public function dpValidation()
    {
        return [
            [
                ['foo', 'bar', 'buz'],
                true,
                'bar',
                true
            ],

            [
                ['foo', 'bar', 'buz'],
                true,
                'buzzzz',
                false
            ],

            [
                ['foo', 'bar', 'buz', 1],
                true,
                '1',
                false
            ],

            [
                ['foo', 'bar', 'buz', 1],
                false,
                '1',
                true
            ],

        ];
    }
}
