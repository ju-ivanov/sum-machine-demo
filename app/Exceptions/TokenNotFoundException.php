<?php

declare(strict_types=1);

namespace App\Exceptions;

class TokenNotFoundException extends RegularException
{
    public const MESSAGE = 'Token not found';
}
