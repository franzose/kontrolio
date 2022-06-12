<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\IsTrue;
use PHPUnit\Framework\TestCase;

class IsTrueTest extends TestCase
{
    public function testValidation(): void
    {
        $rule = new IsTrue;
        
        static::assertFalse($rule->isValid('foo'));
        static::assertFalse($rule->isValid(''));
        static::assertFalse($rule->isValid());
        static::assertTrue($rule->isValid(true));
    }
}