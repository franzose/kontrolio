<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Rules;

use Kontrolio\Rules\ArrayNormalizer;
use Kontrolio\Rules\Core\EqualTo;
use Kontrolio\Rules\Core\NotEqualTo;
use Kontrolio\Rules\Instantiator;
use Kontrolio\Rules\Parser;
use Kontrolio\Rules\Repository;
use PHPUnit\Framework\TestCase;

final class ArrayNormalizerTest extends TestCase
{
    public function testNormalize(): void
    {
        $normalizer = new ArrayNormalizer(new Parser(new Repository(new Instantiator(), [
            EqualTo::class,
            NotEqualTo::class
        ])));

        $expected = [
            'foo' => [
                new EqualTo('foo'),
                new NotEqualTo('bar')
            ],
            'bar' => [
                new EqualTo('foo'),
            ],
            'qux' => [
                static function ($value) {
                    return $value === 'qux';
                }
            ]
        ];

        $result = $normalizer->normalize([
            'foo' => 'equal_to:foo|not_equal_to:bar',
            'bar' => new EqualTo('foo'),
            'qux' => static function ($value) {
                return $value === 'qux';
            }
        ]);

        static::assertEquals($expected, $result);
    }
}
