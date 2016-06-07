<?php

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractComparisonRule;

class IdenticalTo extends AbstractComparisonRule
{
    /**
     * Validates input.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function isValid($input = null)
    {
        return $input === $this->value;
    }
}