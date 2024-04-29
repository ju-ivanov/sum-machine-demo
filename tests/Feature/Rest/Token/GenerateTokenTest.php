<?php

declare(strict_types=1);

namespace Tests\Feature\Rest\Token;

use App\Repositories\Interfaces\TokenRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\FeatureTestCase;

class GenerateTokenTest extends FeatureTestCase
{
    private string $method = 'POST';
    private string $url = '/api/token';

    public function testGenerateToken(): void
    {
        $this->truncate()->all();

        $response = $this->json($this->method, $this->url);

        $tokenRepository = $this->app->make(TokenRepositoryInterface::class);
        $tokens = $tokenRepository->findAll();

        self::assertCount(1, $tokens);

        $token = $tokens[0];

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure(['data' => $this->structure()->token()]);
        $response->assertJsonPath('data.token', $token->getId()->toString());
    }
}
