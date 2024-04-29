<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Responses\Serializers;

use App\Http\Responses\Serializers\CountResponseSerializer;
use Tests\Unit\UnitTestCase;

class CountResponseSerializerTest extends UnitTestCase
{
    /**
     * @dataProvider inputDataProvider
     */
    public function testSerialize(int $input): void
    {
        $serializer = new CountResponseSerializer();
        $result = $serializer->serialize($input);

        self::assertEquals($input, $result['count']);
    }

    public static function inputDataProvider(): array
    {
        return [[-1000000], [-10], [0], [10], [1000000]];
    }
}
