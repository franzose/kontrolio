<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core\TestHelpers;

use Kontrolio\Rules\AbstractRule;

class DummyRule extends AbstractRule
{
    public function isValid(mixed $input = null): bool
    {
        return true;
    }
}