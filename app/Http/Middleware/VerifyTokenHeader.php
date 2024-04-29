<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Http\Responses\ResponseFactory;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class VerifyTokenHeader
{
    public const TOKEN_HEADER = 'Token';

    /**
     * @return JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $tokenHeader = (string) $request->header(self::TOKEN_HEADER);

        try {
            Uuid::fromString($tokenHeader);
        } catch (InvalidUuidStringException) {
            return ResponseFactory::failure('Token header is missed or has invalid format (should be UUID)', Response::HTTP_BAD_REQUEST);
        }

        return $next($request);
    }
}
