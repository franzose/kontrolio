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
    private $value;
    private $attribute;

    /**
     * @param string $attribute
     * @param mixed $value
     */
    public function __construct($attribute, $value = null)
    {
        $this->attribute = $attribute;
        $this->value = $value;
    }

    public function getName()
    {
        return $this->attribute;
    }

    public function getValue()
    {
        return $this->value;
    }

    /**
     * Indicates whether the attribute can skip validation by the given rule.
     *
     * @param RuleInterface $rule
     *
     * @return bool
     */
    public function canSkip(RuleInterface $rule)
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
    public function conformsTo(RuleInterface $rule)
    {
        return $rule->isValid($this->value) ||
               $rule->canSkipValidation($this->value) ||
               ($rule->emptyValueAllowed() && $this->isEmpty());
    }

    public function isEmpty()
    {
        return $this->value === null || $this->value === '';
    }
}
