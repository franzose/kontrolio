<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\Alphadash;
use PHPUnit\Framework\TestCase;

class AlphadashTest extends TestCase
{
    public function testValidation()
    {
        $rule = new Alphadash;

        $this->assertFalse($rule->isValid('føó'));
        $this->assertFalse($rule->isValid(''));
        $this->assertTrue($rule->isValid('foo-_1234'));
        $this->assertTrue($rule->isValid('foo-_'));
    }
}