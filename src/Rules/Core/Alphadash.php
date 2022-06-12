<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Validation rule for alphanumeric characters, dashes, and underscores.
 *
 * @package Kontrolio\Rules\Core
 */
final class Alphadash extends AbstractRule
{
    public function isValid(mixed $input = null): bool
    {
        return (bool) preg_match('/^([-a-z0-9_-])+$/i', $input);
    }
}
