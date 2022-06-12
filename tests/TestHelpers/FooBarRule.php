<?php
declare(strict_types=1);

namespace Kontrolio\Tests\TestHelpers;

use Kontrolio\Rules\AbstractRule;

class FooBarRule extends AbstractRule
{
    public function isValid(mixed $input = null): bool
    {
        return $input === 'bar';
    }
    
    public function getMessage(): string
    {
        return '';
    }
}