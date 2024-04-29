<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Responses\Serializers;

use App\Http\Responses\Serializers\SumResponseSerializer;
use Tests\Unit\UnitTestCase;

class SumResponseSerializerTest extends UnitTestCase
{
    /**
     * @dataProvider inputDataProvider
     */
    public function testSerialize(int $input): void
    {
        $serializer = new SumResponseSerializer();
        $result = $serializer->serialize($input);

        self::assertEquals($input, $result['sum']);
    }

    public static function inputDataProvider(): array
    {
        return [[-1000000], [-10], [0], [10], [1000000]];
    }
}
