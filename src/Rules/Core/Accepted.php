<?php

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Accepted validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
class Accepted extends AbstractRule
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
        return in_array($input, ['yes', 'on', 1, '1', true, 'true'], true);
    }
}