<?php
declare(strict_types=1);

namespace Kontrolio\Tests\TestHelpers;

use Kontrolio\Rules\AbstractRule;

class EmptyRule extends AbstractRule
{
    public function isValid(mixed $input = null): bool
    {
        return true;
    }

    public function emptyValueAllowed(): bool
    {
        return true;
    }

    public function getMessage(): string
    {
        return '';
    }
}