<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
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
            'name' => ['required', 'string'],
            'email' => ['required', 'string','email'],
            'password' => ['required', 'string'],
            'role_id' => ['required', 'string', 'exists:roles,id'],
        ];
    }

    public function messages()
    {
        return [
            'password.required' => 'The :attribute field is required.',
            'password.string' => 'The :attribute field is string',
        ];
    }

//protected function failedValidation(Validator $validator)
//{
//    dd(1);
//    throw new HttpResponseException(restful_exception(new ValidationException($validator)));
//}
}
