<?php

namespace Kontrolio\Tests\TestHelpers;

use Kontrolio\Rules\AbstractRule;

class IsNotEmpty extends AbstractRule
{
    public function isValid($input = null)
    {
        return $input !== null && $input !== '';
    }
}