<?php
declare(strict_types=1);

namespace Kontrolio\Tests\TestHelpers;

use Kontrolio\Rules\AbstractRule;

class SkippableRule extends AbstractRule
{
    public function isValid(mixed $input = null): bool
    {
        return $input === 'foo';
    }

    public function canSkipValidation(mixed $input = null): bool
    {
        return $input === 'foo';
    }

    public function getMessage(): string
    {
        return '';
    }
}