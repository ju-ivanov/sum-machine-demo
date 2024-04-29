<?php

declare(strict_types=1);

namespace App\Exceptions;

class EmptyStackException extends RegularException
{
    public const MESSAGE = 'Trying to retrieve number from empty stack';
}
