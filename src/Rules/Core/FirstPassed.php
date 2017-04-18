<?php

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;
use Kontrolio\Rules\RuleInterface;

/**
 * Validation rule passing when the first of the given rules is passed
 *
 * @package Kontrolio\Rules\Core
 */
class FirstPassed extends AbstractRule
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
        foreach ($this->rules as $rule) {
            if (($result = $rule->isValid($input)) === true) {
                return $result;
            }
        }

        return false;
    }
}
