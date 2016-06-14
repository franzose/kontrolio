<?php

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

class NotBlank extends AbstractRule
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
        return $input !== null && $input !== '';
    }
}