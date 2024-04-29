<?php

declare(strict_types=1);

namespace Tests\Feature\Rest\SumMachine;

use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\FeatureTestCase;

class GetSumTest extends FeatureTestCase
{
    private string $method = 'GET';
    private string $url = '/api/sum';

    public function testWithoutToken(): void
    {
        $response = $this->json($this->method, $this->url);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJsonStructure($this->structure()->error());
    }

    public function testWithInvalidToken(): void
    {
        $requestHeaders = [
            'Token' => Uuid::uuid4()->toString(),
        ];

        $response = $this->json($this->method, $this->url, [], $requestHeaders);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $response->assertJsonStructure($this->structure()->error());
    }

    public function testWithEmptyStack(): void
    {
        $requestHeaders = [
            'Token' => $this->generateTokenValue(),
        ];

        $response = $this->json($this->method, $this->url, [], $requestHeaders);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['data' => $this->structure()->sum()]);
        $response->assertJsonPath('data.sum', 0);
    }

    public function testGetSum(): void
    {
        $this->truncate()->all();

        $token = $this->persist()->token();

        $number1 = $this->persist()->number($token);
        $number2 = $this->persist()->number($token);
        $number3 = $this->persist()->number($token);

        $requestHeaders = [
            'Token' => $token->getId()->toString(),
        ];

        $response = $this->json($this->method, $this->url, [], $requestHeaders);

        $sum = $number1->getNumber() + $number2->getNumber() + $number3->getNumber();

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['data' => $this->structure()->sum()]);
        $response->assertJsonPath('data.sum', $sum);
    }
}
