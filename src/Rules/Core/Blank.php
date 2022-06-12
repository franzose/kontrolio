<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Blank value validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
class Blank extends AbstractRule
{
    public function isValid(mixed $input = null): bool
    {
        return $input === null || $input === '';
    }
}
