<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;
use Kontrolio\Rules\RuleInterface;

/**
 * Validation rule passing when all the given rules are passing
 *
 * @package Kontrolio\Rules\Core
 */
final class EachPassed extends AbstractRule
{
    /**
     * @var RuleInterface[]
     */
    private array $rules;

    public function __construct(RuleInterface ...$rules)
    {
        $this->rules = $rules;
    }

    public function isValid(mixed $input = null): bool
    {
        return count($this->getPassedRules($input)) === count($this->rules);
    }

    /**
     * Filters rules and returns only passed ones
     *
     * @param mixed $input
     *
     * @return RuleInterface[]
     */
    private function getPassedRules(mixed $input): array
    {
        return array_filter($this->rules, static fn (RuleInterface $rule) => $rule->isValid($input));
    }
}
