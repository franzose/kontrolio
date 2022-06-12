<?php
declare(strict_types=1);

namespace Kontrolio\Tests\TestHelpers;

use Kontrolio\Rules\AbstractRule;

class IsNotEmpty extends AbstractRule
{
    public function isValid($input = null)
    {
        return $input !== null && $input !== '';
    }
}