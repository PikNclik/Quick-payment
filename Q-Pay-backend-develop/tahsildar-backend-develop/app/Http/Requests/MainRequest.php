<?php

namespace App\Http\Requests;

use http\Exception\RuntimeException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Mockery\Exception;

class MainRequest extends FormRequest
{
    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     * @throws ValidationException
     */
    public function failedValidation(Validator $validator): void
    {
        // Check on accept key in the header of the request.
        if (request()->header('accept') !== 'application/json') {
            // Call on parent logic.
            parent::failedValidation($validator);
        } else {
            // Throw exceptions.
            throw new HttpResponseException(
                response()->json([
                    'message' => $validator->messages()->all()[0],
                    'status' => false,
                    'data' => null,
                    'errors' => $validator->messages()->all(),
                    'status_code' => 422
                ])
            );


        }
    }

    /**
     * Throws a Json response with unauthorized error.
     *
     * @throws AuthorizationException
     */
    public function failedAuthorization()
    {
        // Check on accept key in the header of the request.
        if (request()->header('accept') !== 'application/json') {
            // Call on parent logic.
            parent::failedAuthorization();
        } else {
            // Throw exceptions.
            throw new HttpResponseException(
                response()->json([
                    'message' => '',
                    'status' => false,
                    'data' => [],
                    'errors' => __('errors.UNAUTHORIZED'),
                    'status_code' => JsonResponse::HTTP_UNAUTHORIZED
                ], 401)
            );
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }
}
