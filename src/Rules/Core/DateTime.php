<?php

namespace Kontrolio\Rules\Core;

use DateTime as PhpDateTime;
use Kontrolio\Rules\AbstractRule;

class DateTime extends AbstractRule
{
    const PATTERN = '/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/';
    const FORMAT = 'Y-m-d H:i:s';

    /**
     * Validates input.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function isValid($input = null)
    {
        if ($input === null || $input === '') {
            return false;
        }

        $input = (string) $input;

        PhpDateTime::createFromFormat(static::FORMAT, $input);
        $errors = PhpDateTime::getLastErrors();

        if ($errors['error_count'] > 0) {
            $this->violations[] = 'format';

            return false;
        }

        foreach ($errors['warnings'] as $warning) {
            if ($warning === 'The parsed date was invalid') {
                $this->violations[] = 'date';
            } else if ($warning === 'The parsed time was invalid') {
                $this->violations[] = 'time';
            } else {
                $this->violations[] = 'format';
            }
        }

        return !$this->hasViolations();
    }
}