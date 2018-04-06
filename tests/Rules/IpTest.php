<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\Ip;
use PHPUnit\Framework\TestCase;

class IpTest extends TestCase
{
    public function testValidation()
    {
        static::assertFalse((new Ip)->isValid('foo'));
        static::assertTrue((new Ip)->isValid('192.168.1.1'));
        static::assertTrue((new Ip(Ip::V6))->isValid('::1'));
        static::assertFalse((new Ip(Ip::V6))->isValid('foo'));
    }
}