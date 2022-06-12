<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractComparisonRule;

/**
 * Identity validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
class IdenticalTo extends AbstractComparisonRule
{
    public function isValid(mixed $input = null): bool
    {
        return $input === $this->value;
    }
}
