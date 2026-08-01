<?php

namespace App\Http\Controllers;

use App\Models\Applicant;

class VerificationController extends Controller
{
    public function show(Applicant $applicant)
    {
        abort_unless(
            $applicant->verification_status === 'verified',
            404
        );

        return view('verification.show', compact('applicant'));
    }
}
