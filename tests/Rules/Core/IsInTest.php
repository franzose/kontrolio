<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\IsIn;
use PHPUnit\Framework\TestCase;

/**
 * Class IsInTest
 * @package Kontrolio\Tests\Rules
 * @author maximkou <maximkou@gmail.com>
 */
class IsInTest extends TestCase
{

    /**
     * @param array $haystack
     * @param bool $strict
     * @param string $input
     * @param bool $expectedResult
     * @dataProvider dpValidation
     */
    public function testValidation(array $haystack, bool $strict, string $input, bool $expectedResult): void
    {
        $rule = new IsIn($haystack, $strict);

        static::assertEquals(
            $expectedResult,
            $rule->isValid($input)
        );
    }

    public function dpValidation(): array
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
