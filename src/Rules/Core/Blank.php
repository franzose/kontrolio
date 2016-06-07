<?php

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Blank value validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
class Blank extends AbstractRule
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
        return $input === null || $input === '';
    }
}