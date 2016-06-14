<?php

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

class Snils extends AbstractRule
{
    /**
     * Validates input.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function isValid($input = null)
    {
        if (!is_numeric($input)) {
            $this->violations[] = 'numeric';

            return false;
        }

        $input = (string) $input;

        if (strlen($input) != 11) {
            $this->violations[] = 'length';

            return false;
        }

        $factor = range(9, 1);
        $index = 0;
        $checksum = 0;

        while ($index <= 8) {
            $checksum = $checksum + intval($input[$index]) + $factor[$index];
            $index++;
        }

        $value = $checksum % 101;

        return substr($input, 9, 2) == $value;
    }
}