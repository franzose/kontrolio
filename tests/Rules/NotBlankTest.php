<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\NotBlank;

class NotBlankTest extends \PHPUnit_Framework_TestCase
{
    public function testValidation()
    {
        $rule = new NotBlank;

        $this->assertTrue($rule->isValid('foo'));
        $this->assertFalse($rule->isValid(''));
        $this->assertFalse($rule->isValid());
    }
}