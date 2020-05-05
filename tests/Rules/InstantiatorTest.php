<?php

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\AbstractRule;
use Kontrolio\Rules\Core\EqualTo;
use Kontrolio\Rules\Instantiator;
use Kontrolio\Rules\RuleInterface;
use Kontrolio\Validator;
use PHPUnit\Framework\TestCase;
use ReflectionException;
use UnexpectedValueException;

final class InstantiatorTest extends TestCase
{
    /**
     * @dataProvider exceptionDataProvider
     * @param string $class
     * @param string $message
     *
     * @throws ReflectionException
     */
    public function testThrowsIfClassIsNotInstantiable($class, $message)
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage($message);

        (new Instantiator())->make($class);
    }

    public function exceptionDataProvider()
    {
        return [
            [AbstractRule::class, 'Rule class must be instantiable.'],
            [Validator::class, sprintf('Rule must implement %s.', RuleInterface::class)]
        ];
    }

    public function testInstantiatesTheRule()
    {
        $rule = (new Instantiator())->makeWithArgs(EqualTo::class, ['foo']);

        static::assertInstanceOf(EqualTo::class, $rule);
        static::assertTrue($rule->isValid('foo'));
    }
}
