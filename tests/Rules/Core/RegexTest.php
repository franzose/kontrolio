<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\Regex;
use PHPUnit\Framework\TestCase;

class RegexTest extends TestCase
{
    public function testMatching(): void
    {
        $rule = new Regex('/[a-z]{2}/');

        static::assertTrue($rule->isValid('ab'));
        static::assertFalse($rule->isValid(''));
        static::assertFalse($rule->isValid(null));
        static::assertFalse($rule->isValid('жз'));
    }
}
