<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractComparisonRule;

/**
 * Less than or equal validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
final class LessThanOrEqual extends AbstractComparisonRule
{
    public function isValid(mixed $input = null): bool
    {
        return $input <= $this->value;
    }
}
