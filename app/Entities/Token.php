<?php

declare(strict_types=1);

namespace App\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Ramsey\Uuid\UuidInterface;

#[Entity]
#[Table(name: 'tokens')]
class Token extends AbstractEntity
{
    use TimestampableEntity;

    #[Id, Column(type: 'uuid')]
    private UuidInterface $id;

    public function __construct()
    {
        $this->id = $this->generateId();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }
}
