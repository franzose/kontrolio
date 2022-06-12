<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use InvalidArgumentException;
use LogicException;
use Kontrolio\Rules\AbstractRule;

/**
 * Length validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
class Length extends AbstractRule
{
    /**
     * Length validation rule constructor.
     *
     * @param int|null $min Minimum length
     * @param int|null $max Maximum length
     * @param string|null $charset Charset
     * @throws InvalidArgumentException
     * @throws LogicException
     */
    public function __construct(
        private readonly ?int $min = null,
        private readonly ?int $max = null,
        private readonly ?string $charset = 'UTF-8'
    ) {
        if ($min === null && $max === null) {
            throw new InvalidArgumentException('Either option "min" or "max" must be given.');
        }

        if ($min !== null && $max !== null && $min > $max) {
            throw new LogicException('"Min" option cannot be greater that "max".');
        }

        if ($max !== null && $max < $min) {
            throw new LogicException('"Max" option cannot be less that "min".');
        }
    }

    /**
     * Validates input.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function isValid(mixed $input = null): bool
    {
        if ($input === null || $input === '') {
            return false;
        }

        $input = (string) $input;

        if (!$invalidCharset = !@mb_check_encoding($input, $this->charset)) {
            $length = mb_strlen($input, $this->charset);
        }

        if ($invalidCharset) {
            $this->violations[] = 'charset';

            return false;
        }

        if ($this->max !== null && $length > $this->max) {
            $this->violations[] = 'max';

            return false;
        }

        if ($this->min !== null && $length < $this->min) {
            $this->violations[] = 'min';

            return false;
        }

        return true;
    }
}
