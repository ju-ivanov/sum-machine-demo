<?php

declare(strict_types=1);

namespace App\Exceptions;

use RuntimeException;

/**
 * Regular exceptions are the runtime exceptions for predefined
 * situations that allowed to be thrown from controller layer
 * and then caught by centralized exception handler.
 */
class RegularException extends RuntimeException {}
