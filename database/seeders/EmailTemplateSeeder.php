<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name'    => 'Applicant Approved',
                'slug'    => 'applicant_approved',
                'subject' => 'Your Application Has Been Approved – {{ system_name }}',
                'body'    => $this->approvedBody(),
                'is_active' => true,
            ],
            [
                'name'    => 'Applicant Rejected',
                'slug'    => 'applicant_rejected',
                'subject' => 'Update on Your Application – {{ system_name }}',
                'body'    => $this->rejectedBody(),
                'is_active' => true,
            ],
        ];

        foreach ($templates as $template) {
            EmailTemplate::updateOrCreate(
                ['slug' => $template['slug']],
                $template
            );
        }
    }

    private function approvedBody(): string
    {
        return <<<'HTML'
<p>Dear {{ applicant_name }},</p>
<p>We are pleased to inform you that your application has been <strong>approved</strong>.</p>
<p><strong>Application Details</strong></p>
<ul>
<li>Category: {{ applicant_category }}</li>
<li>Place of Examination: {{ place_of_examination }}</li>
<li>Date Submitted: {{ application_date }}</li>
</ul>
<p>Please keep this email for your records. Further instructions will be provided if needed.</p>
<p>Thank you for your interest in {{ system_name }}.</p>
<p>Respectfully,<br>{{ system_name }}</p>
<p><em>This is an automated message. Please do not reply directly to this email.</em></p>
HTML;
    }

    private function rejectedBody(): string
    {
        return <<<'HTML'
<p>Dear {{ applicant_name }},</p>
<p>Thank you for submitting your application to {{ system_name }}.</p>
<p>After careful review, we regret to inform you that your application has been <strong>rejected</strong>.</p>
<p><strong>Application Details</strong></p>
<ul>
<li>Category: {{ applicant_category }}</li>
<li>Place of Examination: {{ place_of_examination }}</li>
<li>Date Submitted: {{ application_date }}</li>
</ul>
<p><strong>Remarks:</strong><br>{{ remarks }}</p>
<p>If you have questions, please contact our office during business hours.</p>
<p>Respectfully,<br>{{ system_name }}</p>
<p><em>This is an automated message. Please do not reply directly to this email.</em></p>
HTML;
    }
}
