<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

final class Between extends AbstractRule
{
    public function __construct(
        private readonly mixed $min,
        private readonly mixed $max
    ) {
    }
    
    public function isValid(mixed $input = null): bool
    {
        return (new GreaterThan($this->min))->isValid($input) &&
               (new LessThan($this->max))->isValid($input);
    }
}
