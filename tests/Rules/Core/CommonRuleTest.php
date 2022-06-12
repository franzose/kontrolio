<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Tests\Rules\Core\TestHelpers\DummyRule;
use PHPUnit\Framework\TestCase;

class CommonRuleTest extends TestCase
{
    public function testGetNameReturnsSnakeCase(): void
    {
        $rule = new DummyRule;

        static::assertEquals('dummy', $rule->getName());
    }
    
    public function testAllowingEmptyConstructor(): void
    {
        static::assertTrue(DummyRule::allowingEmptyValue()->emptyValueAllowed());
    }
}