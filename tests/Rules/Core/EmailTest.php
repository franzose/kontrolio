<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    public function testBasicValidation(): void
    {
        static::assertFalse((new Email)->isValid(''));
        static::assertTrue((new Email)->isValid('test@gmail.com'));
    }

    public function testMxAndHostValidation(): void
    {
        $rule = new Email(true, true);
        $valid = $rule->isValid('blah@askdjlaksd.%^&');
        $violations = $rule->getViolations();

        static::assertFalse($valid);
        static::assertCount(2, $violations);
        static::assertEquals(['mx', 'host'], $violations);
    }
}