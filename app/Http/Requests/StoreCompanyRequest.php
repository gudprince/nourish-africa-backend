<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Traits\BaseResponse;

class StoreCompanyRequest extends FormRequest
{   
    use BaseResponse;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'  => 'required|string',
            'company_email'  => 'required|email|max:255|unique:companies',
            'location'  => 'required|string|',
            'user_id'  => "required|exists:users,id",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            $this->sendError('An Error Occured', $errors,JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}