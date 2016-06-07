<?php

namespace Kontrolio\Tests\Rules\TestHelpers;

use Kontrolio\Rules\AbstractRule;

class DummyRule extends AbstractRule
{
    /**
     * Validates input.
     *
     * @param mixed $input
     *
     * @return bool
     */
    public function isValid($input = null)
    {
        return true;
    }
}