<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\CallableRuleWrapper;
use PHPUnit\Framework\TestCase;

class CallableRuleWrapperTest extends TestCase
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
        
        static::assertEquals('foo', $rule->getName());
        static::assertTrue($rule->isValid());
        static::assertTrue($rule->emptyValueAllowed());
        static::assertTrue($rule->canSkipValidation());
    }
}