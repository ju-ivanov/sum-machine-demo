<?php

declare(strict_types=1);

namespace App\Providers;

use App\Entities\Number;
use App\Entities\Token;
use App\Repositories\Doctrine\NumberRepository;
use App\Repositories\Doctrine\TokenRepository;
use App\Repositories\Interfaces\NumberRepositoryInterface;
use App\Repositories\Interfaces\TokenRepositoryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    private ?EntityManagerInterface $em = null;

    public function register(): void
    {
        $this->app->bind(Connection::class, function () {
            return $this->em()->getConnection();
        });

        $this->app->bind(TokenRepositoryInterface::class, function () {
            return new TokenRepository($this->em(), $this->em()->getClassMetadata(Token::class));
        });

        $this->app->bind(NumberRepositoryInterface::class, function () {
            return new NumberRepository($this->em(), $this->em()->getClassMetadata(Number::class));
        });
    }

    /**
     * @throws BindingResolutionException
     */
    private function em(): EntityManagerInterface
    {
        if (! $this->em instanceof EntityManagerInterface) {
            $this->em = $this->app->make(EntityManagerInterface::class);
        }

        return $this->em;
    }
}
