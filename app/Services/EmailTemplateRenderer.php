<?php

namespace App\Services;

use App\Models\Applicant;
use App\Models\EmailTemplate;

class EmailTemplateRenderer
{
    /**
     * Available placeholders and their descriptions for the admin UI.
     */
    public static function availablePlaceholders(): array
    {
        return [
            'applicant_name'       => 'Full name of the applicant',
            'first_name'           => 'First name',
            'last_name'            => 'Last name',
            'applicant_category'   => 'Applicant category label',
            'place_of_examination' => 'Place of examination',
            'application_date'     => 'Date the application was submitted',
            'verification_status'  => 'Current verification status',
            'remarks'              => 'Verification / rejection remarks',

            'verification_qr'      => 'Applicant verification QR Code',

            'system_name'          => 'System or institution name',
            'current_date'         => 'Current date',
        ];
    }

    /**
     * Build placeholder values from an Applicant model.
     */
    public function dataFromApplicant(Applicant $applicant): array
    {
        $qr = $applicant->getFirstMedia('verification_qr');

        return [
            'applicant_name'       => $applicant->full_name,
            'first_name'           => $applicant->first_name,
            'last_name'            => $applicant->last_name,
            'applicant_category'   => $applicant->applicant_type_label,
            'place_of_examination' => $applicant->place_of_examination,
            'application_date'     => $applicant->created_at?->format('F d, Y') ?? '',
            'verification_status'  => $applicant->verification_status_label,
            'remarks'              => $applicant->remarks ?: '—',

            'verification_qr' => $qr
                ? '<div style="text-align:center;margin:25px 0;">
                    <img src="' . $qr->getFullUrl() . '"
                         alt="Verification QR"
                         width="180"
                         style="display:block;margin:auto;">
                    <div style="margin-top:8px;font-size:12px;color:#6c757d;">
                        Scan this QR Code to verify your registration.
                    </div>
               </div>'
                : '',

            'system_name' => config('app.name', 'Abuyog Community College'),
            'current_date' => now()->format('F d, Y'),
        ];
    }

    /**
     * Sample data for previews and test emails.
     */
    public function sampleData(): array
    {
        return [
            'applicant_name'       => 'Juan Dela Cruz',
            'first_name'           => 'Juan',
            'last_name'            => 'Dela Cruz',
            'applicant_category'   => 'Abuyognon',
            'place_of_examination' => 'Abuyog Community College, Abuyog, Leyte',
            'application_date'     => now()->subDays(3)->format('F d, Y'),
            'verification_status'  => 'Verified',
            'remarks'              => 'Documents verified successfully.',
            'system_name'          => config('app.name', 'Abuyog Community College'),
            'current_date'         => now()->format('F d, Y'),
            'verification_qr' => '
            <div style="text-align:center;margin:25px 0;">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=Sample"
                    width="180">
                <div style="margin-top:8px;font-size:12px;color:#6c757d;">
                    Sample Verification QR Code
                </div>
            </div>',
        ];
    }

    /**
     * Replace {{ placeholder }} tokens in a string.
     */
    public function replace(string $content, array $data): string
    {
        $rawPlaceholders = [
            'verification_qr',
        ];

        return preg_replace_callback(
            '/\{\{\s*([a-zA-Z0-9_]+)\s*\}\}/',
            function ($matches) use ($data, $rawPlaceholders) {

                $key = $matches[1];

                if (! array_key_exists($key, $data)) {
                    return $matches[0];
                }

                if (in_array($key, $rawPlaceholders, true)) {
                    return (string) $data[$key];
                }

                return e((string) $data[$key]);
            },
            $content
        );
    }

    /**
     * Render subject and body for a template slug + data.
     *
     * @return array{subject: string, body: string}|null
     */
    public function render(string $slug, array $data): ?array
    {
        $template = EmailTemplate::findBySlug($slug);

        if (! $template || ! $template->is_active) {
            return null;
        }

        return [
            'subject' => $this->replace($template->subject, $data),
            'body'    => $this->replace($template->body, $data),
        ];
    }

    /**
     * Render using an Applicant model.
     */
    public function renderForApplicant(string $slug, Applicant $applicant): ?array
    {
        return $this->render($slug, $this->dataFromApplicant($applicant));
    }
}
