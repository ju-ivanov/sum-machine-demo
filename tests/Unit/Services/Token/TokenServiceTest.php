<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Token;

use App\Entities\Token;
use App\Exceptions\TokenNotFoundException;
use App\Repositories\Interfaces\TokenRepositoryInterface;
use App\Services\Token\TokenService;
use Ramsey\Uuid\Uuid;
use Tests\Unit\UnitTestCase;

class TokenServiceTest extends UnitTestCase
{
    private TokenRepositoryInterface $tokenRepositoryMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->tokenRepositoryMock = $this->createMock(TokenRepositoryInterface::class);
    }

    public function testGenerate(): void
    {
        $this->tokenRepositoryMock
            ->expects($this->once())
            ->method('save');

        $tokenService = new TokenService($this->tokenRepositoryMock);

        $token = $tokenService->generate();

        self::assertInstanceOf(Token::class, $token);
    }

    public function testExtractExistingToken(): void
    {
        $tokenId = Uuid::uuid4();
        $existingToken = $this->create()->token();

        $this->tokenRepositoryMock
            ->expects($this->once())
            ->method('find')
            ->with($tokenId)
            ->willReturn($existingToken);

        $tokenService = new TokenService($this->tokenRepositoryMock);

        $token = $tokenService->extract($tokenId);

        self::assertInstanceOf(Token::class, $token);
        self::assertEquals($existingToken->getId(), $token->getId());
    }

    public function testExtractMissingToken(): void
    {
        $tokenId = Uuid::uuid4();

        $this->tokenRepositoryMock
            ->expects($this->once())
            ->method('find')
            ->with($tokenId)
            ->willReturn(null);

        $tokenService = new TokenService($this->tokenRepositoryMock);

        $this->expectException(TokenNotFoundException::class);

        $tokenService->extract($tokenId);
    }
}
