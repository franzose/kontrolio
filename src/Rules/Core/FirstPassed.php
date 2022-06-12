<?php
declare(strict_types=1);

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
    private array $rules;

    /**
     * Validation rule constructor
     *
     * @param RuleInterface[] ...$rules
     */
    public function __construct(RuleInterface ...$rules)
    {
        $this->rules = $rules;
    }

    public function isValid(mixed $input = null): bool
    {
        foreach ($this->rules as $rule) {
            if (($result = $rule->isValid($input)) === true) {
                return $result;
            }
        }

        return false;
    }
}
