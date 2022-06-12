<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\Alpha;
use PHPUnit\Framework\TestCase;

class AlphaTest extends TestCase
{
    public function testValidation()
    {
        $rule = new Alpha;

        static::assertFalse($rule->isValid('føó'));
        static::assertFalse($rule->isValid(''));
        static::assertFalse($rule->isValid('foo-_1234'));
        static::assertTrue($rule->isValid('foo'));
    }
}