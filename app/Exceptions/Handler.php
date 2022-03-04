<?php

namespace App\Exceptions;

use App\Traits\ApiResponder;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Throwable;

class Handler extends ExceptionHandler
{

    use ApiResponder;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param Throwable $e
     * @return Response|JsonResponse
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof ValidationException) {
            $errors = $e->validator->getMessageBag();
            return $this->respond('Validation Failed', $errors, ResponseAlias::HTTP_UNPROCESSABLE_ENTITY);
        }
        else if ($e instanceof ModelNotFoundException) {
            return $this->respond(trans('messages.not_found'), [],ResponseAlias::HTTP_NOT_FOUND);
        }
        else if ($e instanceof UnauthorizedException) {
            return $this->respond('Unauthorized', [],ResponseAlias::HTTP_UNAUTHORIZED);
        }
        else if ($e instanceof BadRequestException) {
            return $this->respond('Bad request', [], ResponseAlias::HTTP_BAD_REQUEST);
        }
        else if ($e instanceof AuthenticationException) {
            return $this->respond('Unauthorized', $e->getMessage(), ResponseAlias::HTTP_FORBIDDEN);
        }
        else if ($e instanceof AuthorizationException) {
            return $this->respond('Unauthorized', $e->getMessage(), ResponseAlias::HTTP_FORBIDDEN);
        }
        else {
            if (env('APP_DEBUG')) {
                return parent::render($request, $e);
            }
            return $this->respond(trans('messages.try_later'), [], 500);
        }
    }
}
