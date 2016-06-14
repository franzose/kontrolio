<?php

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

class Kpp extends AbstractRule
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
        $input = (string) $input;

        if (strlen($input) != 9) {
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