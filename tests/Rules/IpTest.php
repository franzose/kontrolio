<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\Ip;

class IpTest extends \PHPUnit_Framework_TestCase
{
    public function testValidation()
    {
        $this->assertFalse((new Ip)->isValid('foo'));
        $this->assertTrue((new Ip)->isValid('192.168.1.1'));
        $this->assertTrue((new Ip(Ip::V6))->isValid('::1'));
        $this->assertFalse((new Ip(Ip::V6))->isValid('foo'));
    }
}