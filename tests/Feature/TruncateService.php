<?php

declare(strict_types=1);

namespace Tests\Feature;

use Doctrine\DBAL\Connection;

class TruncateService
{
    public function __construct(
        private readonly Connection $connection
    ) {}

    public function all(): void
    {
        $this->numbers();
        $this->tokens();
    }

    public function tokens(): void
    {
        $this->truncateTable('tokens');
    }

    public function numbers(): void
    {
        $this->truncateTable('numbers');
    }

    private function truncateTable(string $tableName): void
    {
        $this->connection->executeStatement('TRUNCATE ' . $tableName . ' CASCADE');
    }
}
