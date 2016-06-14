<?php

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

class Sometimes extends AbstractRule
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
        return true;
    }

    /**
     * When true, validation will be bypassed if validated value is null or an empty string.
     *
     * @return bool
     */
    public function emptyValueAllowed()
    {
        return true;
    }
}