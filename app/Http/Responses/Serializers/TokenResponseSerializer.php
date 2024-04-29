<?php

declare(strict_types=1);

namespace App\Http\Responses\Serializers;

use App\Entities\Token;

class TokenResponseSerializer
{
    public function serialize(Token $token): array
    {
        return [
            'token' => $token->getId()->toString(),
        ];
    }
}
