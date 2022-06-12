<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * True validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
final class IsTrue extends AbstractRule
{
    public function isValid(mixed $input = null): bool
    {
        return $input === true;
    }
}
