<?php

namespace Kontrolio\Tests\TestHelpers;

use Kontrolio\Rules\AbstractRule;

class SkippableRule extends AbstractRule
{
    public function isValid($input = null)
    {
        return $input === 'foo';
    }

    public function canSkipValidation($input = null)
    {
        return $input === 'foo';
    }

    public function getMessage()
    {
        return '';
    }
}