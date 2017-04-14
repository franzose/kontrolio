<?php

namespace Kontrolio\Tests;

use Kontrolio\Rules\Core\Length;
use Kontrolio\Rules\Core\Sometimes;
use Kontrolio\Rules\Core\UntilFirstFailure;
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
        
        $messages = [
            'zero' => 'foo',
            'one' => 'bar',
            'two' => 'baz',
            'three' => 'taz'
        ];

        $aliases = require __DIR__ . '/../config/aliases.php';
        $validator = (new Validator($data, $rules, $messages))->extend($aliases);
        
        $this->assertEquals($data, $validator->getData());
        $this->assertEquals($rules, $validator->getRules());
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
        
        $validator = (new Validator($data, $rules, $messages))->extend([IsNotEmpty::class]);

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

    public function testBypassingValidation()
    {
        $rules = [
            'foo' => [
                new Sometimes(),
                new Length(5, 15)
            ],
            'bar' => [
                new Sometimes(),
                new Length(5, 15)
            ]
        ];

        $data = [
            'foo' => null,
            'bar' => ''
        ];

        $this->assertTrue($this->validate($data, $rules));
    }

    public function testBypassingEmpyValues()
    {
        $rules = [
            'foo' => (new Length(5, 15))->allowEmptyValue(),
            'bar' => new Length(5, 15)
        ];

        $data = [
            'foo' => null,
            'bar' => '12345'
        ];

        $this->assertTrue($this->validate($data, $rules));

        $data = [
            'foo' => '123',
            'bar' => '12345'
        ];

        $this->assertFalse($this->validate($data, $rules));
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

    public function testStoppingOnFirstFailureWithinRulesGroup()
    {
        $data = [
            'foo' => null,
            'bar' => 1234,
            'baz' => null
        ];

        $rules = [
            'foo' => [
                new IsNotEmpty,
                new FooBarRule
            ],
            'bar' => [
                new UntilFirstFailure,
                new IsNotEmpty,
                new FooBarRule,
                new Length(5, 10)
            ],
            'baz' => [
                new FooBarRule,
                new IsNotEmpty,
            ]
        ];

        $messages = [
            'foo.is_not_empty' => 'Foo must not be empty.',
            'bar.is_not_empty' => 'Bar must not be empty.',
            'bar.foo_bar' => 'Bar must be bar.',
        ];

        $validator = new Validator($data, $rules, $messages);
        $validator->validate();
        $errors = $validator->getErrors();

        $this->assertCount(3, $errors);
        $this->assertTrue(isset($errors['foo'], $errors['bar'], $errors['baz']));
        $this->assertCount(2, $errors['foo']);
        $this->assertCount(1, $errors['bar']);
    }

    public function testGetErrorsListReturnsPlainArray()
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
            'foo.is_not_empty' => 'message 1',
            'foo.foo_bar' => 'message 2',
            'bar.is_not_empty' => 'message 3',
            'bar.foo_bar' => 'message 4'
        ];

        $validator = new Validator($data, $rules, $messages);
        $validator->validate();

        $errors = $validator->getErrorsList();
        $expected = [
            'message 1',
            'message 2',
            'message 3',
            'message 4'
        ];

        $this->assertCount(4, $errors);
        $this->assertEquals($expected, $errors);
    }
}
