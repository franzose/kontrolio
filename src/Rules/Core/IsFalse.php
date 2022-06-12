<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * False values validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
final class IsFalse extends AbstractRule
{
    public function isValid(mixed $input = null): bool
    {
        return $input === false;
    }
}
