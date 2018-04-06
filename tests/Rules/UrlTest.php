<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    public function testValidation()
    {
        $this->assertTrue((new Url)->isValid('http://example.com'));
        $this->assertFalse((new Url)->isValid('$%)@(#$)@(#@_#)$@#_$)'));
        $this->assertTrue((new Url(true))->isValid('http://google.com'));
    }
}