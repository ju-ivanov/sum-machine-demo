<?php

declare(strict_types=1);

namespace Tests;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected ?Generator $faker = null;
    private ?EntityCreateService $entityCreateService = null;

    protected function getFaker(): Generator
    {
        if (! $this->faker instanceof Generator) {
            $this->faker = Factory::create();
        }

        return $this->faker;
    }

    protected function create(): EntityCreateService
    {
        if (! $this->entityCreateService instanceof EntityCreateService) {
            $this->entityCreateService = new EntityCreateService();
        }

        return $this->entityCreateService;
    }
}
