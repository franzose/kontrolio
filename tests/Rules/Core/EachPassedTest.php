<?php

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\EachPassed;
use Kontrolio\Rules\Core\Email;
use Kontrolio\Rules\Core\Length;
use PHPUnit\Framework\TestCase;

class EachPassedTest extends TestCase
{
    public function testValidation()
    {
        $rule = new EachPassed(
            new Email(),
            new Length(5, 17)
        );

        static::assertFalse($rule->isValid('foo'));
        static::assertFalse($rule->isValid('example@example.com'));
        static::assertTrue($rule->isValid('admin@example.com'));
    }
}
