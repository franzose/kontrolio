<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractComparisonRule;

/**
 * Equality validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
class EqualTo extends AbstractComparisonRule
{
    public function isValid(mixed $input = null): bool
    {
        return $input == $this->value;
    }
}