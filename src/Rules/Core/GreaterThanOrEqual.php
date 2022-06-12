<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractComparisonRule;

/**
 * Greater than or equal validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
class GreaterThanOrEqual extends AbstractComparisonRule
{
    public function isValid(mixed $input = null): bool
    {
        return $input >= $this->value;
    }
}
