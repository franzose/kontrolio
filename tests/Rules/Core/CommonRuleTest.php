<?php

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Tests\Rules\Core\TestHelpers\DummyRule;
use PHPUnit\Framework\TestCase;

class CommonRuleTest extends TestCase
{
    public function testGetNameReturnsSnakeCase()
    {
        $rule = new DummyRule;

        static::assertEquals('dummy', $rule->getName());
    }
    
    public function testAllowingEmptyConstructor()
    {
        static::assertTrue(DummyRule::allowingEmptyValue()->emptyValueAllowed());
    }
}