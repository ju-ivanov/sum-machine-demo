<?php

declare(strict_types=1);

namespace App\Repositories\Doctrine;

use App\Entities\Token;
use App\Repositories\Interfaces\TokenRepositoryInterface;

/**
 * @method Token[] findBy(array $criteria, ?array $orderBy = null, $limit = null, $offset = null)
 * @method ?Token  findOneBy(array $criteria)
 */
class TokenRepository extends AbstractRepository implements TokenRepositoryInterface {}
