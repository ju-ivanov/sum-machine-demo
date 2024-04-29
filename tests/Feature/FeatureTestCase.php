<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

abstract class FeatureTestCase extends TestCase
{
    private ?EntityPersistService $entityPersistService = null;
    private ?TruncateService $truncateService = null;
    private ?StructureFactory $structureFactory = null;

    protected function persist(): EntityPersistService
    {
        if (! $this->entityPersistService instanceof EntityPersistService) {
            $this->entityPersistService = $this->app->make(EntityPersistService::class);
        }

        return $this->entityPersistService;
    }

    protected function truncate(): TruncateService
    {
        if (! $this->truncateService instanceof TruncateService) {
            $this->truncateService = $this->app->make(TruncateService::class);
        }

        return $this->truncateService;
    }

    protected function structure(): StructureFactory
    {
        if (! $this->structureFactory instanceof StructureFactory) {
            $this->structureFactory = $this->app->make(StructureFactory::class);
        }

        return $this->structureFactory;
    }

    protected function generateTokenValue(): string
    {
        $token = $this->persist()->token();

        return $token->getId()->toString();
    }
}
