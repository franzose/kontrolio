<?php
declare(strict_types=1);

namespace Kontrolio\Rules\Core;

/**
 * Accepted validation rule.
 *
 * @package Kontrolio\Rules\Core
 */
final class Accepted extends IsIn
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
