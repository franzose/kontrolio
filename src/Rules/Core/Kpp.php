<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

final class Kpp extends AbstractRule
{
    public function isValid(mixed $input = null): bool
    {
        $input = (string) $input;

        if (strlen($input) !== 9) {
            $this->violations[] = 'length';

            return false;
        }

        if (!preg_match('/\d{4}[\dA-Z][\dA-Z]\d{3}/', $input)) {
            $this->violations[] = 'format';

            return false;
        }

        return true;
    }
}
