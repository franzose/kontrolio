<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use DateTime as PhpDateTime;
use Kontrolio\Rules\AbstractRule;

/**
 * Date and time validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
final class DateTime extends AbstractRule
{
    public const PATTERN = '/^(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})$/';
    public const FORMAT = 'Y-m-d H:i:s';

    public function isValid(mixed $input = null): bool
    {
        if ($input === null || $input === '') {
            return false;
        }

        $input = (string) $input;

        PhpDateTime::createFromFormat(self::FORMAT, $input);
        $errors = PhpDateTime::getLastErrors();

        if ($errors['error_count'] > 0) {
            $this->violations[] = 'format';

            return false;
        }

        foreach ($errors['warnings'] as $warning) {
            if ($warning === 'The parsed date was invalid') {
                $this->violations[] = 'date';
            } elseif ($warning === 'The parsed time was invalid') {
                $this->violations[] = 'time';
            } else {
                $this->violations[] = 'format';
            }
        }

        return !$this->hasViolations();
    }
}
