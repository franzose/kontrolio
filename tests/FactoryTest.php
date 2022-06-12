<?php
declare(strict_types=1);

namespace Kontrolio\Tests;

use Kontrolio\Factory;
use PHPUnit\Framework\TestCase;

class FactoryTest extends TestCase
{
    public function testConstructor(): void
    {
        $factory = new Factory();

        static::assertEquals(require __DIR__ . '/../config/aliases.php', $factory->getAvailable());
    }
    
    public function testFactory(): void
    {
        $factory = new Factory();
        $data = ['foo' => 'bar'];
        $rules = ['foo' => function() { return true; }];
        $validator = $factory->make($data, $rules, $data);
        
        static::assertEquals($data, $validator->getData());
        static::assertEquals($rules, $validator->getRules());
        static::assertEquals($data, $validator->getMessages());
        static::assertEquals(require __DIR__ . '/../config/aliases.php', $validator->getAvailable());
    }
}