<?php

declare(strict_types=1);

namespace Tests\Unit\Http\Responses\Serializers;

use App\Http\Responses\Serializers\TokenResponseSerializer;
use Tests\Unit\UnitTestCase;

class TokenResponseSerializerTest extends UnitTestCase
{
    public function testSerialize(): void
    {
        $token = $this->create()->token();
        $serializer = new TokenResponseSerializer();
        $result = $serializer->serialize($token);

        self::assertEquals($token->getId()->toString(), $result['token']);
    }
}
