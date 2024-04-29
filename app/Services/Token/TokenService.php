<?php

declare(strict_types=1);

namespace App\Services\Token;

use App\Entities\Token;
use App\Exceptions\DataSourceException;
use App\Exceptions\TokenNotFoundException;
use App\Repositories\Interfaces\TokenRepositoryInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\Response;

class TokenService
{
    public function __construct(protected TokenRepositoryInterface $tokenRepository) {}

    /**
     * @throws DataSourceException
     */
    public function generate(): Token
    {
        $token = new Token();

        $this->tokenRepository->save($token);

        return $token;
    }

    /**
     * @throws TokenNotFoundException
     */
    public function extract(UuidInterface $tokenId): Token
    {
        $token = $this->tokenRepository->find($tokenId);

        if (! $token instanceof Token) {
            throw new TokenNotFoundException(TokenNotFoundException::MESSAGE, Response::HTTP_FORBIDDEN);
        }

        return $token;
    }
}
