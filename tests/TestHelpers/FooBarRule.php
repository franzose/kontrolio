<?php
declare(strict_types=1);

namespace Kontrolio\Tests\TestHelpers;

use Kontrolio\Rules\AbstractRule;

class FooBarRule extends AbstractRule
{
    public function isValid($input = null)
    {
        return $input === 'bar';
    }
    
    public function getMessage()
    {
        return '';
    }
}