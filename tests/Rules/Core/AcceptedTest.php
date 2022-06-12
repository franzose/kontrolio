<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules\Core;

use Kontrolio\Rules\Core\Accepted;
use PHPUnit\Framework\TestCase;

class AcceptedTest extends TestCase
{
    public function testValidation(): void
    {
        $rule = new Accepted;

        static::assertFalse($rule->isValid('føó'));
        static::assertFalse($rule->isValid(''));

        foreach (['yes', 'on', 1, '1', true, 'true'] as $value) {
            static::assertTrue($rule->isValid($value));
        }
    }
}