<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => ['required', 'email', 'max:150'],
            'password' => ['required', 'string'],
            'remember' => ['sometimes', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'email'    => 'Email Address',
            'password' => 'Password',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'The email field is required.',
            'email.email'       => 'Please enter a valid email address.',
            'password.required' => 'The password field is required.',
        ];
    }

    /**
     * Always return JSON for AJAX login validation failures.
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'message' => 'Please correct the errors below.',
                'errors'  => $validator->errors(),
            ], 422)
        );
    }
}
