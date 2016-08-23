<?php

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Validation rule for alphanumeric characters.
 *
 * @package Kontrolio\Rules\Core
 */
class Alphanum extends AbstractRule
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
        return (bool) preg_match('/^([a-z0-9])+$/i', $input);
    }
}