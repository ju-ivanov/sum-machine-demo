<?php

declare(strict_types=1);

namespace Tests\Feature\Rest\SumMachine;

use App\Repositories\Interfaces\NumberRepositoryInterface;
use DateTime;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\FeatureTestCase;

class RemoveLastNumberTest extends FeatureTestCase
{
    private string $method = 'DELETE';
    private string $url = '/api/number';

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

        $response->assertStatus(Response::HTTP_BAD_REQUEST);
        $response->assertJsonStructure($this->structure()->error());
    }

    public function testRemoveLastNumber(): void
    {
        $this->truncate()->all();

        $token = $this->persist()->token();

        $number1 = $this->create()->number($token);
        $number1->setCreatedAt(DateTime::createFromFormat('Y-m-d', '2024-01-01'));

        $number2 = $this->create()->number($token);
        $number2->setCreatedAt(DateTime::createFromFormat('Y-m-d', '2024-01-10'));

        $number3 = $this->create()->number($token);
        $number3->setCreatedAt(DateTime::createFromFormat('Y-m-d', '2024-01-05'));

        $numberRepository = $this->app->make(NumberRepositoryInterface::class);
        $numberRepository->save($number1, $number2, $number3);

        $requestHeaders = [
            'Token' => $token->getId()->toString(),
        ];

        $response = $this->json($this->method, $this->url, [], $requestHeaders);

        $numbers = $numberRepository->findAll();
        self::assertCount(2, $numbers);

        $lastNumber = $numberRepository->find($number2);
        self::assertNull($lastNumber);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure(['data' => $this->structure()->count()]);
        $response->assertJsonPath('data.count', 2);
    }
}
