<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\BetweenInclusive;
use PHPUnit\Framework\TestCase;

final class BetweenInclusiveTest extends TestCase
{
    public function testValidation()
    {
        static::assertTrue((new BetweenInclusive(5, 10))->isValid(6));
        static::assertTrue((new BetweenInclusive(5, 10))->isValid(5));
        static::assertTrue((new BetweenInclusive(5, 10))->isValid(10));
        static::assertFalse((new BetweenInclusive(5, 10))->isValid(4));
        static::assertFalse((new BetweenInclusive(5, 10))->isValid(11));
        static::assertTrue((new BetweenInclusive('a', 'm'))->isValid('c'));
        static::assertTrue((new BetweenInclusive('a', 'm'))->isValid('a'));
        static::assertTrue((new BetweenInclusive('a', 'm'))->isValid('m'));
        static::assertFalse((new BetweenInclusive('a', 'm'))->isValid('p'));
    }
}
