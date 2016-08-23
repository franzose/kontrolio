<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\Accepted;

class AcceptedTest extends \PHPUnit_Framework_TestCase
{
    public function testValidation()
    {
        $rule = new Accepted;

        $this->assertFalse($rule->isValid('føó'));
        $this->assertFalse($rule->isValid(''));

        foreach (['yes', 'on', 1, '1', true, 'true'] as $value) {
            $this->assertTrue($rule->isValid($value));
        }
    }
}