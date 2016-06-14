<?php

namespace Kontrolio\Rules\Core;

use DateTime as PhpDateTime;
use Kontrolio\Rules\AbstractRule;

class Time extends AbstractRule
{
    const PATTERN = '/^(\d{2}):(\d{2}):(\d{2})$/';

    /**
     * Validates input.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function isValid($input = null)
    {
        if ($input === null || $input === '' || $input instanceof PhpDateTime) {
            return false;
        }

        $input = (string) $input;

        if (!preg_match(static::PATTERN, $input, $matches)) {
            $this->violations[] = 'format';

            return false;
        }

        if (!self::checkTime($matches[1], $matches[2], $matches[3])) {
            $this->violations[] = 'time';

            return false;
        }

        return true;
    }

    /**
     * Checks whether a time is valid.
     *
     * @param int $hour
     * @param int $minute
     * @param int $second
     *
     * @return bool
     */
    protected static function checkTime($hour, $minute, $second)
    {
        return $hour >= 0 && $hour < 24 && $minute >= 0 && $minute < 60 && $second >= 0 && $second < 60;
    }
}