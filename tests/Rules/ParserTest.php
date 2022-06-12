<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\Repository;
use Kontrolio\Rules\Core\EqualTo;
use Kontrolio\Rules\Core\NotEqualTo;
use Kontrolio\Rules\Instantiator;
use Kontrolio\Rules\Parser;
use PHPUnit\Framework\TestCase;

final class ParserTest extends TestCase
{
    public function testParse()
    {
        $parser = new Parser(new Repository(new Instantiator(), [
            EqualTo::class,
            NotEqualTo::class
        ]));

        $rules = $parser->parse('equal_to:foo|not_equal_to:bar');

        static::assertCount(2, $rules);
        static::assertInstanceOf(EqualTo::class, $rules[0]);
        static::assertInstanceOf(NotEqualTo::class, $rules[1]);
        static::assertTrue($rules[0]->isValid('foo'));
        static::assertFalse($rules[1]->isValid('bar'));
    }
}
