<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\Blank;
use PHPUnit\Framework\TestCase;

class BlankTest extends TestCase
{
    public function testValidation(): void
    {
        $rule = new Blank;

        static::assertFalse($rule->isValid('foo'));
        static::assertTrue($rule->isValid(''));
        static::assertTrue($rule->isValid());
    }
}