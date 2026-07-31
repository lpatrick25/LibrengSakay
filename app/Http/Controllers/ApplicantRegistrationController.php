<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicantRegistrationRequest;
use App\Models\Applicant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ApplicantRegistrationController extends Controller
{
    /**
     * Display the applicant registration page (category selection + form).
     */
    public function index(): View
    {
        return view('applicant.registration');
    }

    /**
     * Handle the AJAX registration form submission.
     */
    public function store(ApplicantRegistrationRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            // Handle identification file upload
            $idPath = null;
            if ($request->hasFile('identification')) {
                $file = $request->file('identification');
                $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $idPath = $file->storeAs('ids', $filename, 'public');
            }

            // Persist applicant record
            $applicant = Applicant::create([
                'applicant_type'   => $validated['applicant_type'],
                'last_name'        => $validated['last_name'],
                'first_name'       => $validated['first_name'],
                'middle_name'      => $validated['middle_name'] ?? null,
                'suffix'           => $validated['suffix'] ?? null,
                'place_of_examination' => $validated['place_of_examination'],
                'email'            => $validated['email'] ?? null,
                'contact_number'   => $validated['contact_number'],
                'identification_path' => $idPath,
                'consent_given'    => true,
                'verification_status' => 'pending',
                'id_status'        => $idPath ? 'uploaded' : 'missing',
                'ip_address'       => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Application submitted successfully. Your reference number is #' . str_pad($applicant->id, 6, '0', STR_PAD_LEFT) . '.',
                'data'    => [
                    'id' => $applicant->id,
                ],
            ]);
        } catch (\Throwable $e) {
            // Clean up uploaded file on failure
            if (isset($idPath) && Storage::disk('public')->exists($idPath)) {
                Storage::disk('public')->delete($idPath);
            }

            report($e);

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred while processing your application. Please try again later.',
            ], 500);
        }
    }
}
