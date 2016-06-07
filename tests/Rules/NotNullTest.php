<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\NotNull;

class NotNullTest extends \PHPUnit_Framework_TestCase
{
    public function testValidation()
    {
        $rule = new NotNull;

        $this->assertTrue($rule->isValid('foo'));
        $this->assertTrue($rule->isValid(''));
        $this->assertFalse($rule->isValid());
    }
}