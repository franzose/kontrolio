<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Validation rule by a regular expression
 *
 * @package Kontrolio\Rules\Core
 */
class Regex extends AbstractRule
{
    private string $pattern;

    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    public function isValid(mixed $input = null): bool
    {
        if (empty($input)) {
            return false;
        }

        return (bool) preg_match($this->pattern, $input);
    }
}
