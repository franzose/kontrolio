<?php

namespace Kontrolio\Tests;

use Kontrolio\Rules\CallableRuleWrapper;

class CallableRuleWrapperTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \UnexpectedValueException
     */
    public function testConstructorThrowsOnValidationAbsence()
    {
        new CallableRuleWrapper(['name' => 'foo']);
    }
    
    public function testConstructor()
    {
        $rule = new CallableRuleWrapper([
            'name' => 'foo',
            'valid' => true,
            'empty_allowed' => true,
            'skip' => true
        ]);
        
        $this->assertEquals('foo', $rule->getName());
        $this->assertTrue($rule->isValid());
        $this->assertTrue($rule->emptyValueAllowed());
        $this->assertTrue($rule->canSkipValidation());
    }
}