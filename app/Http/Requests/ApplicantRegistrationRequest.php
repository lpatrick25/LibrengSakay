<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ApplicantRegistrationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $maxKb = (int) config('app.max_upload_kb', env('APP_MAX_UPLOAD_KB', 5120));

        return [
            'applicant_type' => [
                'required',
                'string',
                Rule::in(['abuyognon', 'acc_student', 'non_abuyognon']),
            ],
            'last_name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[\p{L}\s\'\-\.]+$/u',
            ],
            'first_name' => [
                'required',
                'string',
                'max:100',
                'regex:/^[\p{L}\s\'\-\.]+$/u',
            ],
            'middle_name' => [
                'nullable',
                'string',
                'max:100',
                'regex:/^[\p{L}\s\'\-\.]+$/u',
            ],
            'suffix' => [
                'nullable',
                'string',
                'max:20',
            ],
            'place_of_examination' => [
                'required',
                'string',
                'max:150',
            ],
            'email' => [
                'nullable',
                'email:rfc,dns',
                'max:150',
            ],
            'contact_number' => [
                'required',
                'string',
                'max:20',
                'regex:/^[\d\s\-\+\(\)]+$/',
            ],
            'identification' => [
                'required',
                'file',
                'mimes:jpg,jpeg,png,pdf',
                'max:' . $maxKb,
            ],
            'consent' => [
                'required',
                'accepted',
            ],
        ];
    }

    /**
     * Custom attribute names for validation messages.
     */
    public function attributes(): array
    {
        return [
            'applicant_type'       => 'applicant category',
            'last_name'            => 'Last Name',
            'first_name'           => 'First Name',
            'middle_name'          => 'Middle Name',
            'suffix'               => 'Suffix',
            'place_of_examination' => 'Place of Examination',
            'email'                => 'Email Address',
            'contact_number'       => 'Contact Number',
            'identification'       => 'Identification document',
            'consent'              => 'Data Privacy Consent',
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        $maxMb = round((int) config('app.max_upload_kb', env('APP_MAX_UPLOAD_KB', 5120)) / 1024, 1);

        return [
            'applicant_type.required' => 'Please select an applicant category.',
            'applicant_type.in'       => 'The selected applicant category is invalid.',
            'last_name.required'      => 'The Last Name field is required.',
            'last_name.regex'         => 'The Last Name may only contain letters, spaces, hyphens, apostrophes and periods.',
            'first_name.required'     => 'The First Name field is required.',
            'first_name.regex'        => 'The First Name may only contain letters, spaces, hyphens, apostrophes and periods.',
            'middle_name.regex'       => 'The Middle Name may only contain letters, spaces, hyphens, apostrophes and periods.',
            'place_of_examination.required' => 'The Place of Examination field is required.',
            'email.email'             => 'Please enter a valid email address.',
            'contact_number.required' => 'The Contact Number field is required.',
            'contact_number.regex'    => 'Please enter a valid contact number.',
            'identification.required' => 'Please upload a valid identification document.',
            'identification.mimes'    => 'The identification must be a file of type: JPG, JPEG, PNG, or PDF.',
            'identification.max'      => "The identification file may not be greater than {$maxMb} MB.",
            'consent.required'        => 'You must accept the Data Privacy Notice before submitting.',
            'consent.accepted'        => 'You must accept the Data Privacy Notice before submitting.',
        ];
    }

    /**
     * Return JSON validation errors for AJAX requests.
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
