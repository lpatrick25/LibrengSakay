<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateEmailTemplateRequest;
use App\Mail\TemplatedMail;
use App\Models\EmailTemplate;
use App\Services\EmailTemplateRenderer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class EmailTemplateController extends Controller
{
    public function __construct(
        protected EmailTemplateRenderer $renderer
    ) {}

    /**
     * List page – two template cards.
     */
    public function index(): View
    {
        return view('email-templates.index');
    }

    /**
     * Return all templates as JSON (for AJAX card loading).
     */
    public function data(): JsonResponse
    {
        $templates = EmailTemplate::orderBy('id')->get()->map(function (EmailTemplate $t) {
            return [
                'id'         => $t->id,
                'name'       => $t->name,
                'slug'       => $t->slug,
                'subject'    => $t->subject,
                'is_active'  => $t->is_active,
                'updated_at' => $t->updated_at?->format('M d, Y h:i A'),
                'is_protected' => $t->isProtected(),
            ];
        });

        return response()->json([
            'success' => true,
            'data'    => $templates,
            'placeholders' => EmailTemplateRenderer::availablePlaceholders(),
        ]);
    }

    /**
     * Show a single template (for edit form).
     */
    public function show(int $id): JsonResponse
    {
        $template = EmailTemplate::findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => [
                'id'         => $template->id,
                'name'       => $template->name,
                'slug'       => $template->slug,
                'subject'    => $template->subject,
                'body'       => $template->body,
                'is_active'  => $template->is_active,
                'updated_at' => $template->updated_at?->format('M d, Y h:i A'),
            ],
            'placeholders' => EmailTemplateRenderer::availablePlaceholders(),
        ]);
    }

    /**
     * Update subject, body, and active flag.
     */
    public function update(UpdateEmailTemplateRequest $request, int $id): JsonResponse
    {
        $template = EmailTemplate::findOrFail($id);

        $template->update([
            'subject'   => $request->validated('subject'),
            'body'      => $request->validated('body'),
            'is_active' => $request->boolean('is_active', $template->is_active),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Email template updated successfully.',
        ]);
    }

    /**
     * Toggle active status.
     */
    public function toggle(int $id): JsonResponse
    {
        $template = EmailTemplate::findOrFail($id);
        $template->update(['is_active' => ! $template->is_active]);

        return response()->json([
            'success'   => true,
            'message'   => $template->is_active
                ? 'Template has been activated.'
                : 'Template has been deactivated.',
            'is_active' => $template->is_active,
        ]);
    }

    /**
     * Preview rendered subject + body with sample data.
     */
    public function preview(Request $request, int $id): JsonResponse
    {
        $template = EmailTemplate::findOrFail($id);

        // Allow previewing unsaved edits from the editor
        $subject = $request->input('subject', $template->subject);
        $body    = $request->input('body', $template->body);

        $data = $this->renderer->sampleData();

        return response()->json([
            'success' => true,
            'data'    => [
                'subject' => $this->renderer->replace($subject, $data),
                'body'    => $this->renderer->replace($body, $data),
                'sample'  => $data,
            ],
        ]);
    }

    /**
     * Send a test email using sample data.
     */
    public function sendTest(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'email'   => ['required', 'email'],
            'subject' => ['nullable', 'string', 'max:255'],
            'body'    => ['nullable', 'string'],
        ]);

        $template = EmailTemplate::findOrFail($id);

        $subject = $request->input('subject', $template->subject);
        $body    = $request->input('body', $template->body);
        $data    = $this->renderer->sampleData();

        $renderedSubject = $this->renderer->replace($subject, $data);
        $renderedBody    = $this->renderer->replace($body, $data);

        try {
            Mail::to($request->input('email'))
                ->send(new TemplatedMail($renderedSubject, $renderedBody));

            return response()->json([
                'success' => true,
                'message' => 'Test email sent successfully to ' . $request->input('email') . '.',
            ]);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send test email. Please check your mail configuration.',
            ], 500);
        }
    }
}
