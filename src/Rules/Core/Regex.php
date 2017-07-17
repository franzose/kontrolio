<?php

namespace Kontrolio\Rules\Core;

use InvalidArgumentException;
use Kontrolio\Rules\AbstractRule;

/**
 * Validation rule by a regular expression
 *
 * @package Kontrolio\Rules\Core
 */
class Regex extends AbstractRule
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * @param string $pattern
     */
    public function __construct($pattern)
    {
        if (!is_string($pattern)) {
            throw new InvalidArgumentException('Pattern must be a string.');
        }

        $this->pattern = $pattern;
    }

    /**
     * Validates input.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function isValid($input = null)
    {
        if (empty($input)) {
            return false;
        }

        return (bool) preg_match($this->pattern, $input);
    }
}
