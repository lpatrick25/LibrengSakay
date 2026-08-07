<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class ApplicantReportController extends Controller
{
    /**
     * Normalize inconsistent place_of_examination values.
     */
    private function normalizeSchool(string $value): string
    {
        $value = Str::lower(trim($value ?? ''));

        // Leyte National High School
        if (
            Str::contains($value, 'leyte national high') ||
            Str::contains($value, 'leyte high') ||
            Str::contains($value, 'athletic road')
        ) {
            return 'Leyte National High School';
        }

        // Sagkahan National High School
        if (Str::contains($value, 'sagkahan')) {
            return 'Sagkahan National High School';
        }

        // Eastern Visayas State University
        if (
            Str::contains($value, 'evsu') ||
            Str::contains($value, 'eastern visayas')
        ) {
            return 'Eastern Visayas State University (EVSU)';
        }

        // Leyte Normal University - Youngfield Campus (Campus 2)
        if (
            Str::contains($value, 'young field') ||
            Str::contains($value, 'youngfield') ||
            Str::contains($value, 'campus ii') ||
            Str::contains($value, 'campus 2')
        ) {
            return 'Leyte Normal University - Youngfield Campus (LNU)';
        }

        // Leyte Normal University - Campus 1
        if (
            Str::contains($value, 'leyte normal') ||
            Str::contains($value, 'lnu') ||
            Str::contains($value, 'paterno') ||
            Str::contains($value, 'campus i') ||
            Str::contains($value, 'campus 1')
        ) {
            return 'Leyte Normal University (LNU)';
        }

        // San Jose Central School
        if (
            Str::contains($value, 'san jose elementary') ||
            Str::contains($value, 'san jose central')
        ) {
            return 'San Jose Central School';
        }

        return 'Others';
    }

    public function verifiedBySchool()
    {
        $applicants = Applicant::where('verification_status', 'verified')
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        $schools = $applicants
            ->groupBy(function ($applicant) {
                return $this->normalizeSchool($applicant->place_of_examination);
            })
            ->sortKeys();

        $pdf = Pdf::loadView('pdf.verified-by-school', [
            'schools' => $schools,
            'generatedAt' => now(),
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('verified-applicants-by-school.pdf');
    }
}
