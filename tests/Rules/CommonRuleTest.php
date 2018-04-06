<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Tests\Rules\TestHelpers\DummyRule;
use PHPUnit\Framework\TestCase;

class CommonRuleTest extends TestCase
{
    public function testGetNameReturnsSnakeCase()
    {
        $rule = new DummyRule;

        $this->assertEquals('dummy', $rule->getName());
    }
    
    public function testAllowingEmptyConstructor()
    {
        $this->assertTrue(DummyRule::allowingEmptyValue()->emptyValueAllowed());
    }
}