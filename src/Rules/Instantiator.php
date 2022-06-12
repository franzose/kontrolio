<?php
declare(strict_types=1);

namespace Kontrolio\Rules;

use ReflectionClass;
use ReflectionException;
use UnexpectedValueException;

final class Instantiator
{
    /**
     * Returns new instance of a rule by the given class name.
     *
     * @param string $class
     *
     * @return RuleInterface
     * @throws UnexpectedValueException
     * @throws ReflectionException
     */
    public function make(string $class): RuleInterface
    {
        return $this->reflect($class)->newInstanceWithoutConstructor();
    }

    /**
     * Returns new instance of a rule by the given class name and arguments.
     *
     * @param string $class
     * @param array $arguments
     *
     * @return RuleInterface
     * @throws UnexpectedValueException
     * @throws ReflectionException
     */
    public function makeWithArgs(string $class, array $arguments = []): RuleInterface
    {
        return $this->reflect($class)->newInstanceArgs($arguments);
    }

    /**
     * Creates reflection object for the given class name.
     *
     * @param string $class
     *
     * @return ReflectionClass
     * @throws ReflectionException
     */
    private function reflect(string $class): ReflectionClass
    {
        $obj = (new ReflectionClass($class));

        if (!$obj->isInstantiable()) {
            throw new UnexpectedValueException('Rule class must be instantiable.');
        }

        if (!$obj->implementsInterface(RuleInterface::class)) {
            throw new UnexpectedValueException(sprintf('Rule must implement %s.', RuleInterface::class));
        }

        return $obj;
    }
}
