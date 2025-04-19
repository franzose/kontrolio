<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Data;

use Kontrolio\Data\Attribute;
use Kontrolio\Data\Data;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

final class DataTest extends TestCase
{
    /**
     * @dataProvider getTestsDataProvider
     * @param array $data
     * @param string|null $name
     * @param Attribute $expectedAttribute
     */
    #[DataProvider('getTestsDataProvider')]
    public function testGet(array $data, ?string $name, Attribute $expectedAttribute): void
    {
        $data = new Data($data);

        $attribute = $data->get($name);

        static::assertEquals($expectedAttribute, $attribute);
    }

    public static function getTestsDataProvider(): array
    {
        return [
            [['foo' => 'bar'], null, new Attribute(null)],
            [['foo' => 'bar'], 'foo', new Attribute('foo', 'bar')],
            [['foo' => 'bar'], 'qux', new Attribute('qux', null)],
            [['foo' => ['bar' => 'qux']], 'foo', new Attribute('foo', ['bar' => 'qux'])],
        ];
    }
}
