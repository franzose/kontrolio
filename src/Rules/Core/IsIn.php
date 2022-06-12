<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Class IsIn
 * @package Kontrolio\Rules\Core
 * @author maximkou <maximkou@gmail.com>
 */
class IsIn extends AbstractRule
{
    public function __construct(
        private readonly array $haystack = [],
        private readonly bool $strictCompare = true
    ) {
    }

    /**
     * @inheritdoc
     */
    public function isValid(mixed $input = null): bool
    {
        return in_array($input, $this->haystack, $this->strictCompare);
    }
}
