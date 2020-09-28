<?php

namespace App\Http\Requests;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Controllers\Api\ResultType;

class BaseFormRequest extends FormRequest
 {
/**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */ 
        protected function failedValidation(Validator $validator)
        {
            $errors = (new ValidationException($validator))->errors();
                                                                                                    
        throw new HttpResponseException(
            (new ApiController)->apiResponse(ResultType::Errors,
            $errors, 'Validation error!', JsonResponse::HTTP_UNPROCESSABLE_ENTITY)

            );
                   
    } 
    
}