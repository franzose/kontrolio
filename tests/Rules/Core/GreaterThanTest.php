<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\GreaterThan;
use PHPUnit\Framework\TestCase;

class GreaterThanTest extends TestCase
{
    public function testValidation()
    {
        static::assertFalse((new GreaterThan(5))->isValid(5));
        static::assertTrue((new GreaterThan(5))->isValid(10));
        static::assertFalse((new GreaterThan(5))->isValid(0));
        static::assertFalse((new GreaterThan('a'))->isValid('a'));
        static::assertTrue((new GreaterThan('a'))->isValid('f'));
        static::assertFalse((new GreaterThan('c'))->isValid('a'));
    }
}