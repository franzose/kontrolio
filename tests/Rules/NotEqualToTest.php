<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\NotEqualTo;
use PHPUnit\Framework\TestCase;

class NotEqualToTest extends TestCase
{
    public function testValidation()
    {
        $this->assertFalse((new NotEqualTo(5))->isValid(5));
        $this->assertTrue((new NotEqualTo(5))->isValid(6));
        $this->assertFalse((new NotEqualTo('a'))->isValid('a'));
        $this->assertTrue((new NotEqualTo('a'))->isValid('b'));
    }
}