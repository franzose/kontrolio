<?php

namespace Kontrolio\Rules\Core;

use Kontrolio\Rules\AbstractRule;

/**
 * Accepted validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
class Accepted extends IsIn
{

    public function __construct()
    {
        parent::__construct([
            'yes',
            'on',
            1,
            '1',
            true,
            'true'
        ]);
    }
}