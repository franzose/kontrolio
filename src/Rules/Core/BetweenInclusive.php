<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

final class BetweenInclusive extends AbstractRule
{
    public function __construct(
        private readonly mixed $min,
        private readonly mixed $max
    ) {
    }

    public function isValid(mixed $input = null): bool
    {
        return (new GreaterThanOrEqual($this->min))->isValid($input) &&
               (new LessThanOrEqual($this->max))->isValid($input);
    }
}
