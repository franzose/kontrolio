<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\AbstractRule;
use Kontrolio\Rules\Core\EqualTo;
use Kontrolio\Rules\Instantiator;
use Kontrolio\Rules\RuleInterface;
use Kontrolio\Validator;
use PHPUnit\Framework\Attributes\DataProvider;
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
    #[DataProvider('exceptionDataProvider')]
    public function testThrowsIfClassIsNotInstantiable(string $class, string $message): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage($message);

        (new Instantiator())->make($class);
    }

    public static function exceptionDataProvider(): array
    {
        return [
            [AbstractRule::class, 'Rule class must be instantiable.'],
            [Validator::class, sprintf('Rule must implement %s.', RuleInterface::class)]
        ];
    }

    public function testInstantiatesTheRule(): void
    {
        $rule = (new Instantiator())->makeWithArgs(EqualTo::class, ['foo']);

        static::assertInstanceOf(EqualTo::class, $rule);
        static::assertTrue($rule->isValid('foo'));
    }
}
