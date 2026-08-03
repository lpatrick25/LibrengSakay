<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicantRegistrationRequest;
use App\Mail\ApplicationReceivedMail;
use App\Models\Applicant;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ApplicantRegistrationController extends Controller
{
    /**
     * Display the applicant registration page.
     */
    public function index(): View
    {
        return view('applicant.registration');
    }

    /**
     * Store a new applicant.
     */
    public function store(ApplicantRegistrationRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            if (! config('app.registration_open')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Online registration is currently closed. Please check back later.',
                ], 403);
            }

            $existingApplicant = Applicant::where('email', $validated['email'])->first();

            if ($existingApplicant) {
                return response()->json([
                    'success' => false,
                    'message' => 'This email address has already been used.',
                ], 422);
            }

            /*
            |--------------------------------------------------------------------------
            | Create Applicant
            |--------------------------------------------------------------------------
            */

            $applicant = Applicant::create([
                'applicant_type'        => $validated['applicant_type'],
                'last_name'             => $validated['last_name'],
                'first_name'            => $validated['first_name'],
                'middle_name'           => $validated['middle_name'] ?? null,
                'suffix'                => $validated['suffix'] ?? null,
                'place_of_examination'  => $validated['place_of_examination'],
                'email'                 => $validated['email'],
                'contact_number'        => $validated['contact_number'],

                'consent_given'         => true,
                'verification_status'   => 'pending',
                'id_status'             => $request->hasFile('identification')
                    ? 'uploaded'
                    : 'missing',
                'ip_address'            => $request->ip(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Upload Identification using Spatie Media Library
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('identification')) {

                $applicant
                    ->addMediaFromRequest('identification')
                    ->usingName('Identification')
                    ->usingFileName(
                        now()->format('YmdHis') .
                            '_' .
                            uniqid() .
                            '.' .
                            $request->file('identification')->getClientOriginalExtension()
                    )
                    ->toMediaCollection('identification');
            }

            if ($applicant->email) {
                try {
                    Mail::to($applicant->email)
                        ->queue(new ApplicationReceivedMail($applicant));
                } catch (\Throwable $e) {
                    report($e);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully. Your reference number is #' .
                    str_pad($applicant->id, 6, '0', STR_PAD_LEFT) . '.',
                'data' => [
                    'id' => $applicant->id,
                ],
            ]);
        } catch (\Throwable $e) {

            report($e);

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred while processing your application. Please try again later.',
            ], 500);
        }
    }
}
