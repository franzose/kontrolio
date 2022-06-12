<?php
declare(strict_types=1);

namespace Kontrolio\Rules;

abstract class AbstractComparisonRule extends AbstractRule
{
    public function __construct(protected mixed $value)
    {
    }
}
