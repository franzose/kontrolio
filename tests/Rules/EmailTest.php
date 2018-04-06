<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Core\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testBasicValidation()
    {
        static::assertFalse((new Email)->isValid(''));
        static::assertTrue((new Email)->isValid('test@gmail.com'));
    }

    public function testMxAndHostValidation()
    {
        $rule = new Email(true, true);
        $valid = $rule->isValid('blah@askdjlaksd.%^&');
        $violations = $rule->getViolations();

        static::assertFalse($valid);
        static::assertCount(2, $violations);
        static::assertArraySubset(['mx', 'host'], $violations);
    }
}