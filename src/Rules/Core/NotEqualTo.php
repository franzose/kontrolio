<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractComparisonRule;

/**
 * Not equal to validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
class NotEqualTo extends AbstractComparisonRule
{
    public function isValid(mixed $input = null): bool
    {
        return $input != $this->value;
    }
}
