<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Until first failure validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
final class UntilFirstFailure extends AbstractRule
{
    public function isValid(mixed $input = null): bool
    {
        return true;
    }
}
