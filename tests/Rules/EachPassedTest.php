<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\EachPassed;
use Kontrolio\Rules\Core\Email;
use Kontrolio\Rules\Core\Length;

class EachPassedTest extends \PHPUnit_Framework_TestCase
{
    public function testValidation()
    {
        $rule = new EachPassed(
            new Email(),
            new Length(5, 17)
        );

        $this->assertFalse($rule->isValid('foo'));
        $this->assertFalse($rule->isValid('example@example.com'));
        $this->assertTrue($rule->isValid('admin@example.com'));
    }
}
