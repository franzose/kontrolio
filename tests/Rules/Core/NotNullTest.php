<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\NotNull;
use PHPUnit\Framework\TestCase;

class NotNullTest extends TestCase
{
    public function testValidation(): void
    {
        $rule = new NotNull;

        static::assertTrue($rule->isValid('foo'));
        static::assertTrue($rule->isValid(''));
        static::assertFalse($rule->isValid());
    }
}