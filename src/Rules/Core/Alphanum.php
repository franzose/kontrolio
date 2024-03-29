<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Validation rule for alphanumeric characters.
 *
 * @package Kontrolio\Rules\Core
 */
final class Alphanum extends AbstractRule
{
    public function isValid(mixed $input = null): bool
    {
        return (bool) preg_match('/^([a-z0-9])+$/i', $input);
    }
}
