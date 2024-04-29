<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\RegularException;
use App\Http\Responses\ResponseFactory;
use App\Http\Responses\Serializers\TokenResponseSerializer;
use App\Services\Token\TokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class TokenController extends Controller
{
    /**
     * @throws RegularException
     */
    public function generate(
        TokenService $tokenService,
        TokenResponseSerializer $tokenResponseSerializer
    ): JsonResponse {
        $token = $tokenService->generate();

        return ResponseFactory::success(
            $tokenResponseSerializer->serialize($token),
            Response::HTTP_CREATED
        );
    }
}
