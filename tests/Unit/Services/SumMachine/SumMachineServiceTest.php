<?php

declare(strict_types=1);

namespace Tests\Unit\Services\SumMachine;

use App\Exceptions\EmptyStackException;
use App\Repositories\Interfaces\NumberRepositoryInterface;
use App\Services\SumMachine\SumMachineService;
use Tests\Unit\UnitTestCase;

class SumMachineServiceTest extends UnitTestCase
{
    private NumberRepositoryInterface $numberRepositoryMock;

    public function setUp(): void
    {
        parent::setUp();

        $this->numberRepositoryMock = $this->createMock(NumberRepositoryInterface::class);
    }

    public function testAddNumber(): void
    {
        $token = $this->create()->token();

        $this->numberRepositoryMock
            ->expects($this->once())
            ->method('save');

        $this->numberRepositoryMock
            ->expects($this->once())
            ->method('countByToken')
            ->with($token)
            ->willReturn(1);

        $sumMachineService = new SumMachineService($this->numberRepositoryMock);

        $count = $sumMachineService->addNumber($token, rand(-100, 100));

        self::assertEquals(1, $count);
    }

    public function testRemoveLastNumber(): void
    {
        $token = $this->create()->token();
        $existingLastNumber = $this->create()->number($token);

        $this->numberRepositoryMock
            ->expects($this->once())
            ->method('findLastOneByToken')
            ->with($token)
            ->willReturn($existingLastNumber);

        $this->numberRepositoryMock
            ->expects($this->once())
            ->method('remove')
            ->with($existingLastNumber);

        $this->numberRepositoryMock
            ->expects($this->once())
            ->method('countByToken')
            ->with($token)
            ->willReturn(2);

        $sumMachineService = new SumMachineService($this->numberRepositoryMock);

        $count = $sumMachineService->removeLastNumber($token);

        self::assertEquals(2, $count);
    }

    public function testRemoveLastNumberFromEmptyStack(): void
    {
        $token = $this->create()->token();

        $this->numberRepositoryMock
            ->expects($this->once())
            ->method('findLastOneByToken')
            ->with($token)
            ->willReturn(null);

        $this->expectException(EmptyStackException::class);

        $sumMachineService = new SumMachineService($this->numberRepositoryMock);

        $sumMachineService->removeLastNumber($token);
    }

    public function testGetSum(): void
    {
        $token = $this->create()->token();

        $this->numberRepositoryMock
            ->expects($this->once())
            ->method('sumByToken')
            ->with($token)
            ->willReturn(3);

        $sumMachineService = new SumMachineService($this->numberRepositoryMock);

        $count = $sumMachineService->getSum($token);

        self::assertEquals(3, $count);
    }
}
