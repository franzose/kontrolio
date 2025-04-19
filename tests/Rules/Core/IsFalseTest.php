<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\IsFalse;
use PHPUnit\Framework\TestCase;

class IsFalseTest extends TestCase
{
    public function testValidation(): void
    {
        $rule = new IsFalse;

        static::assertFalse($rule->isValid('foo'));
        static::assertFalse($rule->isValid(''));
        static::assertFalse($rule->isValid());
        static::assertTrue($rule->isValid(false));
    }
}