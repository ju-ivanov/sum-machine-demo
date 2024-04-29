<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\UuidInterface;

#[Entity]
#[Table(name: 'numbers')]
class Number extends AbstractEntity
{
    use TimestampableEntity;

    #[Id, Column(type: 'uuid')]
    private UuidInterface $id;

    public function __construct(
        #[ManyToOne(targetEntity: 'Token')]
        private Token $token,
        #[Column(type: 'integer')]
        private int $number
    ) {
        $this->id = $this->generateId();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getToken(): Token
    {
        return $this->token;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function setToken(Token $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }
}
