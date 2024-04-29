<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Entities\Token;
use App\Exceptions\EmptyStackException;
use App\Exceptions\RegularException;
use App\Exceptions\TokenNotFoundException;
use App\Http\Middleware\VerifyTokenHeader;
use App\Http\Requests\AddNumberRequest;
use App\Http\Responses\ResponseFactory;
use App\Http\Responses\Serializers\CountResponseSerializer;
use App\Http\Responses\Serializers\SumResponseSerializer;
use App\Services\SumMachine\SumMachineService;
use App\Services\Token\TokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class SumMachineController extends Controller
{
    public function __construct(
        private readonly Request $request,
        private readonly SumMachineService $sumMachineService,
        private readonly TokenService $tokenService
    ) {}

    /**
     * @throws RegularException
     */
    public function addNumber(
        AddNumberRequest $request,
        CountResponseSerializer $countResponseSerializer
    ): JsonResponse {
        $numbersCount = $this->sumMachineService->addNumber(
            $this->extractToken(),
            $request->input(AddNumberRequest::FIELD_NUMBER)
        );

        return ResponseFactory::success($countResponseSerializer->serialize($numbersCount));
    }

    /**
     * @throws RegularException
     */
    public function removeLastNumber(CountResponseSerializer $countResponseSerializer): JsonResponse
    {
        try {
            $numbersCount = $this->sumMachineService->removeLastNumber($this->extractToken());
        } catch (EmptyStackException $e) {
            return ResponseFactory::failure($e->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return ResponseFactory::success($countResponseSerializer->serialize($numbersCount));
    }

    /**
     * @throws RegularException
     */
    public function getSum(SumResponseSerializer $sumResponseSerializer): JsonResponse
    {
        $sum = $this->sumMachineService->getSum($this->extractToken());

        return ResponseFactory::success($sumResponseSerializer->serialize($sum));
    }

    /**
     * @throws TokenNotFoundException
     */
    private function extractToken(): Token
    {
        $tokenHeader = (string) $this->request->header(VerifyTokenHeader::TOKEN_HEADER);

        return $this->tokenService->extract(Uuid::fromString($tokenHeader));
    }
}
