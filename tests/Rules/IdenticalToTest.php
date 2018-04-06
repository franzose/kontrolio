<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\IdenticalTo;
use PHPUnit\Framework\TestCase;

class IdenticalToTest extends TestCase
{
    public function testValidation()
    {
        $this->assertTrue((new IdenticalTo(5))->isValid(5));
        $this->assertFalse((new IdenticalTo(5))->isValid('5'));
        $this->assertTrue((new IdenticalTo('a'))->isValid('a'));
        $this->assertFalse((new IdenticalTo('a'))->isValid('b'));
    }
}