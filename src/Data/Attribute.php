<?php
declare(strict_types=1);

namespace Kontrolio\Data;

use Kontrolio\Rules\Core\Sometimes;
use Kontrolio\Rules\RuleInterface;

/**
 * Validated attribute.
 */
final class Attribute
{
    public function __construct(
        public readonly ?string $name,
        public readonly mixed $value = null
    ) {
    }

    /**
     * Indicates whether the attribute can skip validation by the given rule.
     *
     * @param RuleInterface $rule
     *
     * @return bool
     */
    public function canSkip(RuleInterface $rule): bool
    {
        return $rule instanceof Sometimes && $this->isEmpty();
    }

    /**
     * Indicates whether the attribute is valid according to the given rule.
     *
     * @param RuleInterface $rule
     *
     * @return bool
     */
    public function conformsTo(RuleInterface $rule): bool
    {
        return $rule->isValid($this->value) ||
               $rule->canSkipValidation($this->value) ||
               ($rule->emptyValueAllowed() && $this->isEmpty());
    }

    public function isEmpty(): bool
    {
        return $this->value === null || $this->value === '';
    }
}
