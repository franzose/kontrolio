<?php

namespace Kontrolio\Tests;

use Kontrolio\Rules\Core\Length;
use Kontrolio\Tests\TestHelpers\IsNotEmpty;
use Kontrolio\Tests\TestHelpers\EmptyRule;
use Kontrolio\Tests\TestHelpers\FooBarRule;
use Kontrolio\Tests\TestHelpers\SkippableRule;
use Kontrolio\Validator;

class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    private function validate($data = [], $rules = [], $messages = [])
    {
        return (new Validator($data, $rules, $messages))->validate();
    }

    public function testConstructor()
    {
        $data = ['name' => 'foo'];
        $rules = [
            'zero' => 'length:5,15',
            'one' => new EmptyRule,
            'two' => [
                new EmptyRule,
                new EmptyRule
            ],
            'three' => [
                new EmptyRule
            ]
        ];

        $expectedRules = [
            'zero' => [new Length(5,15)],
            'one' => [new EmptyRule],
            'two' => [
                new EmptyRule,
                new EmptyRule,
            ],
            'three' => [new EmptyRule]
        ];
        
        $messages = [
            'zero' => 'foo',
            'one' => 'bar',
            'two' => 'baz',
            'three' => 'taz'
        ];

        $validator = new Validator($data, $rules, $messages);
        
        $this->assertEquals($data, $validator->getData());
        $this->assertEquals($expectedRules, $validator->getRules());
        $this->assertEquals($messages, $validator->getMessages());
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testThrowsOnUnknownRule()
    {
        $this->validate(['foo' => 'bar'], ['foo' => 'uknown_rule'], ['foo' => 'error!']);
    }

    public function testParserTakesAvailableRules()
    {
        Validator::extendAvailableRules([IsNotEmpty::class]);

        $data = ['foo' => null];
        $rules = [
            'foo' => [
                new IsNotEmpty,
                new Length(5, 15)
            ]
        ];

        $messages = [
            'foo.is_not_empty' => 'baz',
            'foo.length.min' => 'taz'
        ];

        $errors = ['foo' => ['baz', 'taz']];
        
        $validator = new Validator($data, $rules, $messages);

        $this->assertFalse($validator->validate());
        $this->assertEquals($errors, $validator->getErrors());
    }

    public function testDotNotation()
    {
        $data = ['foo' => ['bar' => null]];
        $rules = ['foo.bar' => [new Length(5, 15)]];
        $messages = ['foo.bar.length.min' => 'baz'];
        $errors = ['foo.bar' => ['baz']];

        $validator = new Validator($data, $rules, $messages);

        $this->assertFalse($validator->validate());
        $this->assertEquals($errors, $validator->getErrors());
    }
    
    public function testBasicValidation()
    {
        $data = ['name' => 'foo'];
        $rules = ['name' => new IsNotEmpty];
        
        $this->assertTrue($this->validate($data, $rules));
    }
    
    public function testFalsyValidation()
    {
        $data = ['name' => null];
        $rule = new IsNotEmpty;
        $rules = ['name' => $rule];
        $messages = ['name' => 'foo'];
        $errors = ['name' => ['foo']];

        $validator = new Validator($data, $rules, $messages);

        $this->assertFalse($validator->validate());
        $this->assertEquals($errors, $validator->getErrors());
    }

    public function testCallbackValidation()
    {
        $callback = function($value) {
            return $value !== null && $value !== '';
        };

        $validator = new Validator(
            ['foo' => null],
            ['foo' => $callback],
            ['foo' => 'Сообщение не должно быть пустым.']
        );

        $errors = ['foo' => ['Сообщение не должно быть пустым.']];

        $this->assertFalse($validator->validate());
        $this->assertEquals($errors, $validator->getErrors());
    }
    
    public function testSkippingValidation()
    {
        $rules = ['foo' => new SkippableRule()];
        $messages = ['foo' => 'bar'];

        $this->assertFalse($this->validate(['foo' => 'bar'], $rules, $messages));
        $this->assertTrue($this->validate(['foo' => 'foo'], $rules, $messages));
        $this->assertTrue($this->validate(['foo' => null], ['foo' => new EmptyRule()], ['foo' => 'baz']));
    }
    
    public function testStoppingOnFirstFailure()
    {
        $data = [
            'foo' => null,
            'bar' => null
        ];
        
        $rules = [
            'foo' => [
                new IsNotEmpty,
                new FooBarRule
            ],
            'bar' => [
                new IsNotEmpty,
                new FooBarRule
            ]
        ];

        $messages = [
            'foo' => 'bar',
            'bar' => 'baz'
        ];
        
        $validator = new Validator($data, $rules, $messages);
        $validator->validate();
        
        $this->assertCount(2, $validator->getErrors());

        $validator = new Validator($data, $rules, $messages);
        $validator->shouldStopOnFirstFailure()->validate();

        $this->assertCount(1, $validator->getErrors());
    }
}