<?php

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

final class BetweenInclusive extends AbstractRule
{
    private $min;
    private $max;

    public function __construct($min, $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    public function isValid($input = null)
    {
        return (new GreaterThanOrEqual($this->min))->isValid($input) &&
               (new LessThanOrEqual($this->max))->isValid($input);
    }
}
