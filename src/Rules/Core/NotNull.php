<?php

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

class NotNull extends AbstractRule
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
        return $input !== null;
    }
}