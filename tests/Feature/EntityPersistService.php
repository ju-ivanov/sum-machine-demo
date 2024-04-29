<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Entities\Number;
use App\Entities\Token;
use App\Repositories\Interfaces\NumberRepositoryInterface;
use App\Repositories\Interfaces\TokenRepositoryInterface;
use Tests\EntityCreateService;

class EntityPersistService
{
    public function __construct(
        private readonly EntityCreateService $entityCreateService,
        private readonly TokenRepositoryInterface $tokenRepository,
        private readonly NumberRepositoryInterface $numberRepository
    ) {}

    public function token(): Token
    {
        $token = $this->entityCreateService->token();

        $this->tokenRepository->save($token);

        return $token;
    }

    public function number(Token $token, ?int $number = null): Number
    {
        $number = $this->entityCreateService->number($token, $number);

        $this->numberRepository->save($number);

        return $number;
    }
}
