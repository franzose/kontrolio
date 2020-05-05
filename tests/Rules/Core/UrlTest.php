<?php

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{
    public function testValidation()
    {
        static::assertTrue((new Url)->isValid('http://example.com'));
        static::assertFalse((new Url)->isValid('$%)@(#$)@(#@_#)$@#_$)'));
        static::assertTrue((new Url(true))->isValid('http://google.com'));
    }
}