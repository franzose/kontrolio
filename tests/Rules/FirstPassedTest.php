<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\EqualTo;
use Kontrolio\Rules\Core\FirstPassed;
use Kontrolio\Rules\Core\IsNull;
use Kontrolio\Rules\Core\Length;

class FirstPassedTest extends \PHPUnit_Framework_TestCase
{
    public function testValidation()
    {
        $rule = new FirstPassed(
            new Length(5, 10),
            new EqualTo('foo'),
            new IsNull()
        );

        $this->assertTrue($rule->isValid('foo'));
    }
}
