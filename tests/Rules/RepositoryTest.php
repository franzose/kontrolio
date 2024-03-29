<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Repository;
use Kontrolio\Rules\Core\EqualTo;
use Kontrolio\Rules\Core\NotEqualTo;
use Kontrolio\Rules\Instantiator;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

final class RepositoryTest extends TestCase
{
    public function testConstructor(): void
    {
        $rules = [
            EqualTo::class,
            NotEqualTo::class
        ];

        $expected = array_combine(['equal_to', 'not_equal_to'], $rules);

        $rules = new Repository(new Instantiator(), $rules);

        static::assertEquals($expected, $rules->all());
    }

    public function testMake(): void
    {
        $rules = new Repository(new Instantiator(), [
            EqualTo::class
        ]);

        $rule = $rules->make('equal_to', ['foo']);

        static::assertInstanceOf(EqualTo::class, $rule);
        static::assertTrue($rule->isValid('foo'));
    }

    public function testHas(): void
    {
        $rules = new Repository(new Instantiator(), [
            EqualTo::class
        ]);

        static::assertTrue($rules->has('equal_to'));
    }

    public function testGet(): void
    {
        $rules = new Repository(new Instantiator(), [
            EqualTo::class
        ]);

        static::assertEquals(EqualTo::class, $rules->get('equal_to'));
    }

    public function testGetThrowsIfThereIsNoSuchRule(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Rule identified by `foo` could not be loaded.');

        $rules = new Repository(new Instantiator(), [
            EqualTo::class
        ]);

        $rules->get('foo');
    }

    public function testAdd(): void
    {
        $rules = [
            EqualTo::class,
            NotEqualTo::class
        ];

        $expected = array_combine(['equal_to', 'not_equal_to'], $rules);

        $repository = new Repository(new Instantiator());

        $repository->add($rules);

        static::assertEquals($expected, $repository->all());
    }
}
