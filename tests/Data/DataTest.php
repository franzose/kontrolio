<?php
declare(strict_types=1);

namespace Kontrolio\Tests\Data;

use Kontrolio\Data\Attribute;
use Kontrolio\Data\Data;
use PHPUnit\Framework\TestCase;

final class DataTest extends TestCase
{
    /**
     * @dataProvider getTestsDataProvider
     * @param array $data
     * @param string $name
     * @param Attribute $expectedAttribute
     */
    public function testGet(array $data, $name, Attribute $expectedAttribute)
    {
        $data = new Data($data);

        $attribute = $data->get($name);

        static::assertEquals($expectedAttribute, $attribute);
    }

    public function getTestsDataProvider()
    {
        return [
            [['foo' => 'bar'], null, new Attribute(null)],
            [['foo' => 'bar'], 'foo', new Attribute('foo', 'bar')],
            [['foo' => 'bar'], 'qux', new Attribute('qux', null)],
            [['foo' => ['bar' => 'qux']], 'foo', new Attribute('foo', ['bar' => 'qux'])],
        ];
    }
}
