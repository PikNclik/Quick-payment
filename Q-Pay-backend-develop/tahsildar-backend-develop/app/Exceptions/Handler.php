<?php

namespace App\Exceptions;

use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;
use Throwable;

class Handler extends ExceptionHandler
{

    public function __construct(Container $container)
    {
        parent::__construct($container);
        if (request()->header('lang'))
        {
            $lang = request()->header('lang');
            if ($lang == 'ar') {
                App::setLocale('ar');
                // set carbon locale en for get all date and time in english.
                Carbon::setLocale('en');
            } else {
                App::setLocale('en');
            }
        }
    }

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
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
    public function render($request, \Throwable $exception)
    {
//          dd($exception);
        if ($request->wantsJson()) {
            return $this->handleApiException($request, $exception);
        } else {
            $retval = parent::render($request, $exception);
        }

        return $retval;
    }

    public function handleApiException($request, $exception)
    {
        $exception = $this->prepareException($exception);

        if ($exception instanceof HttpResponseException) {
            $exception = $exception->getResponse();
        }

        if ($exception instanceof AuthenticationException) {
            $exception =  $this->unauthenticated($request, $exception);
        }

        if ($exception instanceof ValidationException) {
            $exception = $this->convertValidationExceptionToResponse($exception, $request);
        }

        return $this->customApiResponse($exception);
    }

    private function customApiResponse($exception)
    {
        if (method_exists($exception, 'getStatusCode')) {
            $statusCode = $exception->getStatusCode();
        } else {
            $statusCode = 500;
        }

        $errors = [];

        switch ($statusCode) {
            case 401:
                $errors[] = __('errors.unauthorized');
                break;
            case 403:
                $errors[] = __('errors.forbidden');
                break;
            case 404:
                $errors[] = __('errors.not_found');
                break;
            case 405:
                $errors[] = __('errors.method_not_allowed');
                break;
            case 429:
                $errors[] = __('errors.throttle', ['minutes' => ceil($exception->getHeaders()['Retry-After'] / 60)]);
                break;
            case 422:
                foreach ($exception->original['errors'] as $error) {
                    $errors[] = $error;
                }
                break;
            default:
                $errors[] = ($statusCode == 500) ? __('errors.general_error') : $exception->getMessage();
                break;
        }

        $response['status'] = $statusCode;

        return response()->json([
            'message' => $errors[0],
            'status' => false,
            'data' => null,
            'errors' => $errors,
            'status_code' => $statusCode
        ]);
    }
}
