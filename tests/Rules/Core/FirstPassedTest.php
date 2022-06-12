<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\EqualTo;
use Kontrolio\Rules\Core\FirstPassed;
use Kontrolio\Rules\Core\IsNull;
use Kontrolio\Rules\Core\Length;
use PHPUnit\Framework\TestCase;

class FirstPassedTest extends TestCase
{
    public function testValidation(): void
    {
        $rule = new FirstPassed(
            new Length(5, 10),
            new EqualTo('foo'),
            new IsNull()
        );

        static::assertTrue($rule->isValid('foo'));
    }
}
