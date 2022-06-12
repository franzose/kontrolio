<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Date validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
final class Date extends AbstractRule
{
    public const PATTERN = '/^(\d{4})-(\d{2})-(\d{2})$/';

    public function isValid(mixed $input = null): bool
    {
        if ($input === null || $input === '') {
            return false;
        }

        $input = (string) $input;

        if (!preg_match(self::PATTERN, $input, $matches)) {
            $this->violations[] = 'format';

            return false;
        }

        if (!checkdate((int)$matches[2], (int)$matches[3], (int)$matches[1])) {
            $this->violations[] = 'date';

            return false;
        }

        return true;
    }
}
