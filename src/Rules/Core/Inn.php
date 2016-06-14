<?php

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

class Inn extends AbstractRule
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

        switch (strlen($input)) {
            case 10:
                return $this->validateTenDigits($input);

            case 12:
                return $this->validateTwelveDigits($input);

            default:
                $this->violations[] = 'length';
                return false;
        }
    }

    /**
     * Validates ten digits INN.
     *
     * @param string $input
     *
     * @return bool
     */
    protected function validateTenDigits($input)
    {
        $factor = [2, 4, 10, 3, 5, 9, 4, 6, 8, 0];
        $index = 0;
        $checksum = 0;

        while ($index <= 9) {
            $checksum = $checksum + intval($input[$index]) * $factor[$index];
            $index++;
        }

        $value = $checksum % 11;

        if ($value > 9) {
            $value = $value % 10;
        }

        return $input[9] == $value;
    }

    protected function validateTwelveDigits($input)
    {
        $factor = [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8, 0];
        $index = 0;
        $checksum = 0;

        while ($index <= 10) {
            $checksum = $checksum + intval($input[$index]) * $factor[$index + 1];
            $index++;
        }

        $value = $checksum % 11;

        if ($value > 9) {
            $value = $value % 10;
        }

        $index = 0;
        $checksum2 = 0;

        while ($index <= 11) {
            $checksum2 = $checksum2 + intval($input[$index]) * $factor[$index];
            $index++;
        }

        $value2 = $checksum2 % 11;

        if ($value2 > 9) {
            $value2 = $value2 % 10;
        }

        return $input[10] == $value && $input[11] == $value2;
    }
}