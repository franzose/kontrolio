<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\Blank;
use PHPUnit\Framework\TestCase;

class BlankTest extends TestCase
{
    public function testValidation()
    {
        $rule = new Blank;

        $this->assertFalse($rule->isValid('foo'));
        $this->assertTrue($rule->isValid(''));
        $this->assertTrue($rule->isValid());
    }
}