<?php
declare(strict_types=1);

namespace Kontrolio\Rules;

use ReflectionException;
use UnexpectedValueException;

final class Repository
{
    private $rules = [];

    public function __construct(
        private readonly Instantiator $instantiator,
        array $rules = []
    ) {
        $this->add($rules);
    }

    public function all(): array
    {
        return $this->rules;
    }

    /**
     * Creates a new rule instance by the given name and arguments.
     *
     * Example:
     * $rule = $rules->make('equal_to', ['foo']);
     *
     * @param string $name
     * @param array $arguments
     *
     * @return RuleInterface
     * @throws ReflectionException
     */
    public function make(string $name, array $arguments): RuleInterface
    {
        return $this->instantiator->makeWithArgs($this->get($name), $arguments);
    }

    public function has($name): bool
    {
        return array_key_exists($name, $this->rules);
    }

    /**
     * Returns rule class name if it exists.
     *
     * @param string $name
     *
     * @return string
     * @throws UnexpectedValueException
     */
    public function get(string $name): string
    {
        if ($this->has($name)) {
            return $this->rules[$name];
        }

        throw new UnexpectedValueException(
            sprintf('Rule identified by `%s` could not be loaded.', $name)
        );
    }

    /**
     * Appends the given rule class names to the repository.
     *
     * @param array $rules
     *
     * @return $this
     */
    public function add(array $rules): self
    {
        $mapped = array_combine($this->getRuleNames($rules), array_values($rules));

        $this->rules = array_merge($this->rules, $mapped);

        return $this;
    }

    private function getRuleNames(array $rules): array
    {
        return array_map(function ($key) use ($rules) {
            return is_int($key) ? $this->instantiator->make($rules[$key])->getName() : $key;
        }, array_keys($rules));
    }
}
