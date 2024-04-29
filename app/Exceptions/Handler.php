<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Http\Responses\ResponseFactory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateHttpResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    protected bool $isDebugModeEnabled;

    public function __construct(Container $container)
    {
        parent::__construct($container);

        $this->isDebugModeEnabled = config('app.debug');
    }

    /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @param Request $request
     *
     * @return IlluminateHttpResponse|JsonResponse
     */
    public function render($request, Throwable $e)
    {
        $errorMessage = $this->isDebugModeEnabled ? $e->getMessage() : 'Internal server error';
        $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;

        if ($e instanceof RegularException) {
            $errorMessage = $e->getMessage();
            $statusCode = $e->getCode();
        }

        if ($e instanceof ValidationException) {
            $errorMessage = implode('', $e->errors());
            $statusCode = Response::HTTP_BAD_REQUEST;
        }

        if ($e instanceof HttpExceptionInterface) {
            $errorMessage = $e->getMessage();
            $statusCode = $e->getStatusCode();
        }

        if ($e instanceof NotFoundHttpException) {
            $errorMessage = $e->getMessage();
            $statusCode = Response::HTTP_NOT_FOUND;
        }

        return ResponseFactory::failure($errorMessage, $statusCode);
    }
}
