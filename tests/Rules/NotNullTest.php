<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\NotNull;
use PHPUnit\Framework\TestCase;

class NotNullTest extends TestCase
{
    public function testValidation()
    {
        $rule = new NotNull;

        $this->assertTrue($rule->isValid('foo'));
        $this->assertTrue($rule->isValid(''));
        $this->assertFalse($rule->isValid());
    }
}