<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

final class Okpo extends AbstractRule
{
    public function isValid(mixed $input = null): bool
    {
        if (!is_numeric($input)) {
            $this->violations[] = 'numeric';

            return false;
        }

        $input = (string) $input;

        if (strlen($input) !== 8) {
            $this->violations[] = 'length';

            return false;
        }

        $factor1 = range(1, 7);
        $factor2 = range(3, 9);

        $checksum1 = 0;
        $index = 0;

        while ($index <= 6) {
            $checksum1 = $checksum1 + (int)$input[$index] * $factor1[$index];
            $index++;
        }

        $value1 = $checksum1 % 11;

        $index = 0;
        $checksum2 = 0;

        while ($index <= 6) {
            $checksum2 = $checksum2 + (int)$input[$index] * $factor2[$index];
            $index++;
        }

        $value2 = $checksum2 % 11;
        $check = ($value1 > 9 ? $value2 : $value1);

        return $input[7] == $check;
    }
}
