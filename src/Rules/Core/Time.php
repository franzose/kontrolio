<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use DateTime as PhpDateTime;
use Kontrolio\Rules\AbstractRule;

/**
 * Time validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
class Time extends AbstractRule
{
    public const PATTERN = '/^(\d{2}):(\d{2}):(\d{2})$/';

    public function isValid(mixed $input = null): bool
    {
        if ($input === null || $input === '' || $input instanceof PhpDateTime) {
            return false;
        }

        $input = (string) $input;

        if (!preg_match(static::PATTERN, $input, $matches)) {
            $this->violations[] = 'format';

            return false;
        }

        if (!self::checkTime((int)$matches[1], (int)$matches[2], (int)$matches[3])) {
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
    protected static function checkTime(int $hour, int $minute, int $second): bool
    {
        return $hour >= 0 && $hour < 24 && $minute >= 0 && $minute < 60 && $second >= 0 && $second < 60;
    }
}
