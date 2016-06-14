<?php

namespace Kontrolio\Rules\Core;

use DateTime as PhpDateTime;
use DateTimeInterface;
use InvalidArgumentException;
use LogicException;
use Kontrolio\Rules\AbstractRule;

class Range extends AbstractRule
{
    /**
     * @var mixed|null
     */
    protected $min;

    /**
     * @var mixed|null
     */
    protected $max;

    /**
     * Range constructor.
     *
     * @param mixed $min
     * @param mixed $max
     */
    public function __construct($min = null, $max = null)
    {
        if ($min === null && $max === null) {
            throw new InvalidArgumentException('Either option "min" or "max" must be given.');
        }

        if ($max < $min) {
            throw new LogicException('"Max" option cannot be less that "min".');
        }
        
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * Validates input.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function isValid($input = null)
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