<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\IpAddress;
use Kontrolio\Rules\Core\IpAddressVersion;
use PHPUnit\Framework\TestCase;

class IpAddressTest extends TestCase
{
    public function testValidation(): void
    {
        static::assertFalse((new IpAddress)->isValid('foo'));
        static::assertTrue((new IpAddress)->isValid('192.168.1.1'));
        static::assertTrue((new IpAddress(IpAddressVersion::V6))->isValid('::1'));
        static::assertFalse((new IpAddress(IpAddressVersion::V6))->isValid('foo'));
    }
}