<?php

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Class NotBlank
 *
 * @package Kontrolio\Rules\Core
 */
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