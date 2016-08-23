<?php

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Validation rule for alphanumeric characters, dashes, and underscores.
 *
 * @package Kontrolio\Rules\Core
 */
class Alphadash extends AbstractRule
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
        return (bool) preg_match('/^([-a-z0-9_-])+$/i', $input);
    }
}