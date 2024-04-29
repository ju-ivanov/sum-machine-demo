<?php

declare(strict_types=1);

namespace App\Exceptions;

class DataSourceException extends RegularException
{
    public const MESSAGE = 'Cannot access data source';
}
