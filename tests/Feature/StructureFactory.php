<?php

declare(strict_types=1);

namespace Tests\Feature;

class StructureFactory
{
    public function success(): array
    {
        return [
            'data',
        ];
    }

    public function error(): array
    {
        return [
            'error' => [
                'code',
                'message',
            ],
        ];
    }

    public function token(): array
    {
        return [
            'token',
        ];
    }

    public function count(): array
    {
        return [
            'count',
        ];
    }

    public function sum(): array
    {
        return [
            'sum',
        ];
    }
}
