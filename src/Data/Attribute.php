<?php

namespace Kontrolio\Data;

use Kontrolio\Rules\Core\Sometimes;
use Kontrolio\Rules\RuleInterface;

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

    public function canSkip(RuleInterface $rule)
    {
        return $rule instanceof Sometimes && $this->isEmpty();
    }

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
