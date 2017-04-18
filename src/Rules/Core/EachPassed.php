<?php

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;
use Kontrolio\Rules\RuleInterface;

/**
 * Validation rule passing when all the given rules are passing
 *
 * @package Kontrolio\Rules\Core
 */
class EachPassed extends AbstractRule
{
    /**
     * @var RuleInterface[]
     */
    private $rules;

    /**
     * Validation rule constructor
     *
     * @param RuleInterface[] ...$rules
     */
    public function __construct(RuleInterface ...$rules)
    {
        $this->rules = $rules;
    }

    /**
     * Validates input.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function isValid($input = null)
    {
        return count($this->getPassedRules($input)) === count($this->rules);
    }

    /**
     * Filters rules and returns only passed ones
     *
     * @param mixed $input
     *
     * @return array|RuleInterface[]
     */
    private function getPassedRules($input)
    {
        return array_filter($this->rules, function (RuleInterface $rule) use ($input) {
            return $rule->isValid($input) === true;
        });
    }
}
