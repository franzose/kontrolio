<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

final class Ogrn extends AbstractRule
{
    public function isValid(mixed $input = null): bool
    {
        if (!is_numeric($input)) {
            $this->violations[] = 'numeric';

            return false;
        }
        
        $input = (string) $input;
        $length = strlen($input);
        
        if ($length < 13 || $length > 15) {
            $this->violations[] = 'length';

            return false;
        }
        
        if ($length === 13) {
            $result = floor(($input / 10) % 11);

            return ($result === 10 ? $input[12] == 0 : $input[12] == $result);
        }

        if ($length === 15) {
            $result = floor(($input / 10) % 13);

            return ($input[14] == ($result % 10));
        }

        return false;
    }
}
