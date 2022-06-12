<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

class Inn extends AbstractRule
{
    public function isValid(mixed $input = null): bool
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
    protected function validateTenDigits(string $input): bool
    {
        $factor = [2, 4, 10, 3, 5, 9, 4, 6, 8, 0];
        $index = 0;
        $checksum = 0;

        while ($index <= 9) {
            $checksum = $checksum + (int)$input[$index] * $factor[$index];
            $index++;
        }

        $value = $checksum % 11;

        if ($value > 9) {
            $value %= 10;
        }

        return $input[9] == $value;
    }

    protected function validateTwelveDigits(string $input): bool
    {
        $factor = [3, 7, 2, 4, 10, 3, 5, 9, 4, 6, 8, 0];
        $index = 0;
        $checksum = 0;

        while ($index <= 10) {
            $checksum = $checksum + (int)$input[$index] * $factor[$index + 1];
            $index++;
        }

        $value = $checksum % 11;

        if ($value > 9) {
            $value %= 10;
        }

        $index = 0;
        $checksum2 = 0;

        while ($index <= 11) {
            $checksum2 = $checksum2 + (int)$input[$index] * $factor[$index];
            $index++;
        }

        $value2 = $checksum2 % 11;

        if ($value2 > 9) {
            $value2 %= 10;
        }

        return $input[10] == $value && $input[11] == $value2;
    }
}
