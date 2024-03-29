<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use DateTime as PhpDateTime;
use DateTimeInterface;
use InvalidArgumentException;
use LogicException;
use Kontrolio\Rules\AbstractRule;

/**
 * Range of values validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
final class Range extends AbstractRule
{
    private mixed $min;
    private mixed $max;

    public function __construct(mixed $min = null, mixed $max = null)
    {
        if ($min === null && $max === null) {
            throw new InvalidArgumentException('Either option "min" or "max" must be given.');
        }

        if ($min !== null && $max !== null && $min > $max) {
            throw new LogicException('"Min" option cannot be greater that "max".');
        }

        if ($max !== null && $max < $min) {
            throw new LogicException('"Max" option cannot be less that "min".');
        }
        
        $this->min = $min;
        $this->max = $max;
    }

    public function isValid(mixed $input = null): bool
    {
        if ($input === null) {
            return false;
        }

        if (!is_numeric($input) && !$input instanceof DateTimeInterface) {
            $this->violations[] = 'numeric';

            return false;
        }

        if ($input instanceof DateTimeInterface) {
            if (is_string($this->min)) {
                $this->min = new PhpDateTime($this->min);
            }

            if (is_string($this->max)) {
                $this->max = new PhpDateTime($this->max);
            }
        }

        if ($this->max !== null && $input > $this->max) {
            $this->violations[] = 'max';

            return false;
        }

        if ($this->min !== null && $input < $this->min) {
            $this->violations[] = 'min';

            return false;
        }

        return true;
    }
}
