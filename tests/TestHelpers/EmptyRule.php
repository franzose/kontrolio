<?php
declare(strict_types=1);

namespace Kontrolio\Tests\TestHelpers;

use Kontrolio\Rules\AbstractRule;

class EmptyRule extends AbstractRule
{
    public function isValid($input = null)
    {
        return true;
    }

    public function emptyValueAllowed()
    {
        return true;
    }

    public function getMessage()
    {
        return '';
    }
}