<?php
declare(strict_types=1);

namespace Kontrolio\Rules;

final class Parser
{
    private $cache;
    private $rules;

    public function __construct(Repository $rules)
    {
        $this->rules = $rules;
    }

    /**
     * Converts validation string into an array of rule instances.
     *
     * @param string $string validation string like "equal_to:foo|not_equal_to:bar"
     *
     * @return RuleInterface[]
     */
    public function parse($string)
    {
        if (isset($this->cache[$string])) {
            return $this->cache[$string];
        }

        $this->cache[$string] = array_map(function ($rule) {
            return $this->rules->make(...$this->getNameAndArguments($rule));
        }, explode('|', $string));

        return $this->cache[$string];
    }

    /**
     * Takes rule identifier and arguments from the string.
     *
     * @param string $rule
     *
     * @return array
     */
    private function getNameAndArguments($rule)
    {
        $delimpos = strpos($rule, ':');

        if ($delimpos === false) {
            return [$rule, []];
        }

        return [
            substr($rule, 0, $delimpos),
            (array) explode(',', substr($rule, $delimpos + 1))
        ];
    }
}
