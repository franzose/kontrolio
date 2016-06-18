<?php

namespace Kontrolio\Tests;

use Kontrolio\Factory;

class FactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructor()
    {
        $factory = new Factory();

        $this->assertEquals(require __DIR__ . '/../config/aliases.php', $factory->getAvailable());
    }
    
    public function testFactory()
    {
        $factory = new Factory();
        $data = ['foo' => 'bar'];
        $rules = ['foo' => function() { return true; }];
        $validator = $factory->make($data, $rules, $data);
        
        $this->assertEquals($data, $validator->getData());
        $this->assertEquals($rules, $validator->getRules());
        $this->assertEquals($data, $validator->getMessages());
        $this->assertEquals(require __DIR__ . '/../config/aliases.php', $validator->getAvailable());
    }
}