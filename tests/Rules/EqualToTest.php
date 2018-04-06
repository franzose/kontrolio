<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\EqualTo;
use PHPUnit\Framework\TestCase;

class EqualToTest extends TestCase
{
    public function testValidation()
    {
        $this->assertTrue((new EqualTo(5))->isValid(5));
        $this->assertFalse((new EqualTo(5))->isValid(6));
        $this->assertTrue((new EqualTo('a'))->isValid('a'));
        $this->assertFalse((new EqualTo('a'))->isValid('b'));
    }
}