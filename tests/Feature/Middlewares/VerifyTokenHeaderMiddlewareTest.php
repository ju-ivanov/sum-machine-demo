<?php

declare(strict_types=1);

namespace Tests\Feature\Middlewares;

use App\Http\Middleware\VerifyTokenHeader;
use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\FeatureTestCase;

class VerifyTokenHeaderMiddlewareTest extends FeatureTestCase
{
    public function testWithoutToken(): void
    {
        $response = (new VerifyTokenHeader())->handle(request(), fn () => new JsonResponse([], Response::HTTP_OK));

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testWithInvalidToken(): void
    {
        request()->headers->set('Token', 'DefinitelyInvalidToken');

        $response = (new VerifyTokenHeader())->handle(request(), fn () => new JsonResponse([], Response::HTTP_OK));

        $this->assertEquals(Response::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testWithValidToken(): void
    {
        request()->headers->set('Token', Uuid::uuid4()->toString());

        $response = (new VerifyTokenHeader())->handle(request(), fn () => new JsonResponse([], Response::HTTP_OK));

        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
    }
}
