<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('id') ?? $this->route('user');
        $minPassword = (int) config('auth.password_min_length', env('PASSWORD_MIN_LENGTH', 8));
        $changePassword = $this->boolean('change_password');

        $rules = [
            'name'  => ['required', 'string', 'max:150'],
            'email' => [
                'required',
                'email:rfc,dns',
                'max:150',
                Rule::unique('users', 'email')->ignore($userId),
            ],
        ];

        if ($changePassword) {
            $rules['password'] = ['required', 'string', 'min:' . $minPassword, 'confirmed'];
            $rules['password_confirmation'] = ['required', 'string'];
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'name'     => 'Full Name',
            'email'    => 'Email Address',
            'password' => 'Password',
        ];
    }

    public function messages(): array
    {
        $min = (int) config('auth.password_min_length', env('PASSWORD_MIN_LENGTH', 8));

        return [
            'name.required'     => 'The Full Name field is required.',
            'email.required'    => 'The Email Address field is required.',
            'email.email'       => 'Please enter a valid email address.',
            'email.unique'      => 'The email has already been taken.',
            'password.required' => 'The Password field is required when changing password.',
            'password.min'      => "The Password must be at least {$min} characters.",
            'password.confirmed'=> 'The password confirmation does not match.',
        ];
    }

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
