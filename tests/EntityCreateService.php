<?php

declare(strict_types=1);

namespace Tests;

use App\Entities\Number;
use App\Entities\Token;

class EntityCreateService
{
    public function token(): Token
    {
        return new Token();
    }

    public function number(Token $token, ?int $number = null): Number
    {
        return new Number(
            $token,
            $number ?? rand(-100, 100)
        );
    }
}
