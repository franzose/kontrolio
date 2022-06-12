<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\GreaterThanOrEqual;
use PHPUnit\Framework\TestCase;

class GreaterThanOrEqualTest extends TestCase
{
    public function testValidation()
    {
        static::assertTrue((new GreaterThanOrEqual(5))->isValid(5));
        static::assertTrue((new GreaterThanOrEqual(5))->isValid(6));
        static::assertFalse((new GreaterThanOrEqual(5))->isValid(4));
        static::assertTrue((new GreaterThanOrEqual('a'))->isValid('a'));
        static::assertTrue((new GreaterThanOrEqual('a'))->isValid('b'));
        static::assertFalse((new GreaterThanOrEqual('c'))->isValid('a'));
    }
}