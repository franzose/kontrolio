<?php
declare(strict_types=1);

namespace Kontrolio\Tests\TestHelpers;

use Kontrolio\Rules\AbstractRule;
use Kontrolio\Rules\StopsFurtherValidationInterface;

final class StoppingRule extends AbstractRule implements StopsFurtherValidationInterface
{
    public function isValid($input = null)
    {
        return false;
    }
}
