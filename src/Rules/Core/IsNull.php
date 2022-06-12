<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Nullable values validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
class IsNull extends AbstractRule
{
    public function isValid(mixed $input = null): bool
    {
        return $input === null;
    }
}
