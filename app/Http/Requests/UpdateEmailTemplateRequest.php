<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateEmailTemplateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'subject'   => ['required', 'string', 'max:255'],
            'body'      => ['required', 'string'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'subject' => 'Email Subject',
            'body'    => 'Email Body',
        ];
    }

    public function messages(): array
    {
        return [
            'subject.required' => 'The subject field is required.',
            'subject.max'      => 'The subject may not be greater than 255 characters.',
            'body.required'    => 'The email body is required.',
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
