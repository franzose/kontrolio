<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Sometimes validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
class Sometimes extends AbstractRule
{
    public function isValid(mixed $input = null): bool
    {
        return true;
    }

    /**
     * When true, validation will be bypassed if validated value is null or an empty string.
     *
     * @return bool
     */
    public function emptyValueAllowed(): bool
    {
        return true;
    }
}
