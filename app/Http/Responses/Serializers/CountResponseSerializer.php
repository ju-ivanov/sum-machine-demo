<?php

declare(strict_types=1);

namespace App\Http\Responses\Serializers;

class CountResponseSerializer
{
    public function serialize(int $count): array
    {
        return [
            'count' => $count,
        ];
    }
}
