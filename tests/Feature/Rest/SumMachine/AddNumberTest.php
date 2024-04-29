<?php

declare(strict_types=1);

namespace Tests\Feature\Rest\SumMachine;

use App\Repositories\Interfaces\NumberRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\FeatureTestCase;

class AddNumberTest extends FeatureTestCase
{
    private string $method = 'POST';
    private string $url = '/api/number';

    public function testWithoutToken(): void
    {
        $requestData = [
            'number' => $this->getFaker()->numberBetween(-100, 100),
        ];

        $response = $this->json($this->method, $this->url, $requestData, []);

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJsonStructure($this->structure()->error());
    }

    public function testWithInvalidToken(): void
    {
        $requestData = [
            'number' => $this->getFaker()->numberBetween(-100, 100),
        ];
        $requestHeaders = [
            'Token' => Uuid::uuid4()->toString(),
        ];

        $response = $this->json($this->method, $this->url, $requestData, $requestHeaders);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $response->assertJsonStructure($this->structure()->error());
    }

    public function testAddNumber(): void
    {
        $this->truncate()->all();

        $requestData = [
            'number' => $this->getFaker()->numberBetween(-100, 100),
        ];

        $tokenValue = $this->generateTokenValue();
        $requestHeaders = [
            'Token' => $tokenValue,
        ];

        $response = $this->json($this->method, $this->url, $requestData, $requestHeaders);

        $numberRepository = $this->app->make(NumberRepositoryInterface::class);
        $numbers = $numberRepository->findAll();

        self::assertCount(1, $numbers);

        $number = $numbers[0];

        self::assertEquals($requestData['number'], $number->getNumber());
        self::assertEquals($tokenValue, $number->getToken()->getId()->toString());

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['data' => $this->structure()->count()]);
        $response->assertJsonPath('data.count', 1);
    }
}
