<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\IdenticalTo;
use PHPUnit\Framework\TestCase;

class IdenticalToTest extends TestCase
{
    public function testValidation()
    {
        static::assertTrue((new IdenticalTo(5))->isValid(5));
        static::assertFalse((new IdenticalTo(5))->isValid('5'));
        static::assertTrue((new IdenticalTo('a'))->isValid('a'));
        static::assertFalse((new IdenticalTo('a'))->isValid('b'));
    }
}