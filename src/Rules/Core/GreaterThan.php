<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractComparisonRule;

/**
 * Greater than validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
class GreaterThan extends AbstractComparisonRule
{
    public function isValid(mixed $input = null): bool
    {
        return $input > $this->value;
    }
}
