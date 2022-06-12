<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractComparisonRule;

/**
 * Not identical to validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
final class NotIdenticalTo extends AbstractComparisonRule
{
    public function isValid(mixed $input = null): bool
    {
        return $input !== $this->value;
    }
}
