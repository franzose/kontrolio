<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Not null validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
class NotNull extends AbstractRule
{
    public function isValid(mixed $input = null): bool
    {
        return $input !== null;
    }
}
