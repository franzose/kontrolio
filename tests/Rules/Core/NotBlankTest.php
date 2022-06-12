<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\NotBlank;
use PHPUnit\Framework\TestCase;

class NotBlankTest extends TestCase
{
    public function testValidation(): void
    {
        $rule = new NotBlank;

        static::assertTrue($rule->isValid('foo'));
        static::assertFalse($rule->isValid(''));
        static::assertFalse($rule->isValid());
    }
}