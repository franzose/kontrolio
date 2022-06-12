<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\NotIdenticalTo;
use PHPUnit\Framework\TestCase;

class NotIdenticalToTest extends TestCase
{
    public function testValidation(): void
    {
        static::assertFalse((new NotIdenticalTo(5))->isValid(5));
        static::assertTrue((new NotIdenticalTo(5))->isValid('5'));
        static::assertFalse((new NotIdenticalTo('a'))->isValid('a'));
        static::assertTrue((new NotIdenticalTo('a'))->isValid('b'));
    }
}