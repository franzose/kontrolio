<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testBasicValidation()
    {
        $this->assertFalse((new Email)->isValid(''));
        $this->assertTrue((new Email)->isValid('test@gmail.com'));
    }

    public function testMxAndHostValidation()
    {
        $rule = new Email(true, true);
        $valid = $rule->isValid('blah@askdjlaksd.%^&');
        $violations = $rule->getViolations();

        $this->assertFalse($valid);
        $this->assertCount(2, $violations);
        $this->assertArraySubset(['mx', 'host'], $violations);
    }
}