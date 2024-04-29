<?php

declare(strict_types=1);

namespace App\Services\SumMachine;

use App\Entities\Number;
use App\Entities\Token;
use App\Exceptions\DataSourceException;
use App\Exceptions\EmptyStackException;
use App\Repositories\Interfaces\NumberRepositoryInterface;

class SumMachineService
{
    public function __construct(
        private readonly NumberRepositoryInterface $numberRepository
    ) {}

    /**
     * @throws DataSourceException
     */
    public function addNumber(Token $token, int $number): int
    {
        $number = new Number($token, $number);
        $this->numberRepository->save($number);

        return $this->numberRepository->countByToken($token);
    }

    /**
     * @throws EmptyStackException
     */
    public function removeLastNumber(Token $token): int
    {
        $lastNumber = $this->numberRepository->findLastOneByToken($token);

        if (! $lastNumber instanceof Number) {
            throw new EmptyStackException(EmptyStackException::MESSAGE);
        }

        $this->numberRepository->remove($lastNumber);

        return $this->numberRepository->countByToken($token);
    }

    public function getSum(Token $token): int
    {
        return $this->numberRepository->sumByToken($token);
    }
}
