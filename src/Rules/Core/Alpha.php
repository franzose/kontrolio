<?php

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Validation rule for latin characters.
 *
 * @package Kontrolio\Rules\Core
 */
class Alpha extends AbstractRule
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
        return (bool) preg_match('/^([a-z])+$/i', $input);
    }
}