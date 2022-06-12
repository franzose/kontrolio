<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

final class Between extends AbstractRule
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
        return (new GreaterThan($this->min))->isValid($input) &&
               (new LessThan($this->max))->isValid($input);
    }
}
