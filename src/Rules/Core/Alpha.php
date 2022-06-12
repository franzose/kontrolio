<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Validation rule for latin characters.
 *
 * @package Kontrolio\Rules\Core
 */
class Alpha extends AbstractRule
{
    public function isValid(mixed $input = null): bool
    {
        return (bool) preg_match('/^([a-z])+$/i', $input);
    }
}
