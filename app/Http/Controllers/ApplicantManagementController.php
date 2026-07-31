<?php

namespace App\Http\Controllers;

use App\Mail\TemplatedMail;
use App\Models\Applicant;
use App\Services\EmailTemplateRenderer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ApplicantManagementController extends Controller
{
    /**
     * Display the applicant management dashboard.
     */
    public function index(): View
    {
        return view('applicant.management.index');
    }

    /**
     * Return dashboard statistics (AJAX).
     */
    public function statistics(): JsonResponse
    {
        $today = now()->startOfDay();

        return response()->json([
            'success' => true,
            'data'    => [
                'total'            => Applicant::count(),
                'abuyognon'        => Applicant::where('applicant_type', 'abuyognon')->count(),
                'acc_student'      => Applicant::where('applicant_type', 'acc_student')->count(),
                'non_abuyognon'    => Applicant::where('applicant_type', 'non_abuyognon')->count(),
                'submitted_today'  => Applicant::where('created_at', '>=', $today)->count(),
                'pending'          => Applicant::where('verification_status', 'pending')->count(),
                'verified'         => Applicant::where('verification_status', 'verified')->count(),
            ],
        ]);
    }

    /**
     * Server-side data endpoint for Bootstrap Table.
     */
    public function data(Request $request): JsonResponse
    {
        $query = Applicant::query();

        // ---- Global search ----
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('last_name', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%")
                    ->orWhere('contact_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('place_of_examination', 'like', "%{$search}%");
            });
        }

        // ---- Filters ----
        if ($type = $request->input('applicant_type')) {
            if (in_array($type, ['abuyognon', 'acc_student', 'non_abuyognon'], true)) {
                $query->where('applicant_type', $type);
            }
        }

        if ($status = $request->input('verification_status')) {
            if (in_array($status, ['pending', 'verified', 'rejected'], true)) {
                $query->where('verification_status', $status);
            }
        }

        if ($idStatus = $request->input('id_status')) {
            if (in_array($idStatus, ['uploaded', 'missing', 'needs_review'], true)) {
                $query->where('id_status', $idStatus);
            }
        }

        if ($place = $request->input('place_of_examination')) {
            $query->where('place_of_examination', 'like', "%{$place}%");
        }

        // Date filter
        $dateFilter = $request->input('date_filter');
        if ($dateFilter === 'today') {
            $query->whereDate('created_at', today());
        } elseif ($dateFilter === 'yesterday') {
            $query->whereDate('created_at', today()->subDay());
        } elseif ($dateFilter === 'this_week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($dateFilter === 'this_month') {
            $query->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
        } elseif ($dateFilter === 'custom') {
            if ($from = $request->input('date_from')) {
                $query->whereDate('created_at', '>=', $from);
            }
            if ($to = $request->input('date_to')) {
                $query->whereDate('created_at', '<=', $to);
            }
        }

        // ---- Sorting ----
        $sort  = $request->input('sort', 'id');
        $order = strtolower($request->input('order', 'desc')) === 'asc' ? 'asc' : 'desc';

        $allowedSorts = [
            'id',
            'last_name',
            'first_name',
            'applicant_type',
            'place_of_examination',
            'contact_number',
            'email',
            'verification_status',
            'id_status',
            'created_at',
        ];

        if (in_array($sort, $allowedSorts, true)) {
            $query->orderBy($sort, $order);
        } else {
            $query->orderBy('id', 'desc');
        }

        // ---- Pagination ----
        $total = $query->count();
        $limit = max(1, min(100, (int) $request->input('limit', 10)));
        $offset = max(0, (int) $request->input('offset', 0));

        $rows = $query->skip($offset)->take($limit)->get()->map(function (Applicant $a) {
            return [
                'id'                   => $a->id,
                'full_name'            => $a->full_name,
                'applicant_type'       => $a->applicant_type,
                'applicant_type_label' => $a->applicant_type_label,
                'applicant_type_badge' => $a->applicant_type_badge,
                'place_of_examination' => $a->place_of_examination,
                'contact_number'       => $a->contact_number,
                'email'                => $a->email ?? '—',
                'id_status'            => $a->id_status,
                'id_status_label'      => $a->id_status_label,
                'id_status_badge'      => $a->id_status_badge,
                'verification_status'  => $a->verification_status,
                'verification_label'   => $a->verification_status_label,
                'verification_badge'   => $a->verification_status_badge,
                'created_at'           => $a->created_at?->format('M d, Y h:i A'),
                'created_at_raw'       => $a->created_at?->toIso8601String(),
            ];
        });

        return response()->json([
            'total' => $total,
            'rows'  => $rows,
        ]);
    }

    /**
     * Return a single applicant's details (AJAX – for View modal).
     */
    public function show(int $id): JsonResponse
    {
        $applicant = Applicant::findOrFail($id);

        return response()->json([
            'success' => true,
            'data'    => [
                'id'                   => $applicant->id,
                'full_name'            => $applicant->full_name,
                'last_name'            => $applicant->last_name,
                'first_name'           => $applicant->first_name,
                'middle_name'          => $applicant->middle_name,
                'suffix'               => $applicant->suffix,
                'applicant_type'       => $applicant->applicant_type,
                'applicant_type_label' => $applicant->applicant_type_label,
                'applicant_type_badge' => $applicant->applicant_type_badge,
                'place_of_examination' => $applicant->place_of_examination,
                'contact_number'       => $applicant->contact_number,
                'email'                => $applicant->email,
                'identification_path'  => $applicant->identification_path,
                'identification_url'   => $applicant->identification_url,
                'is_image'             => $applicant->is_identification_image,
                'is_pdf'               => $applicant->is_identification_pdf,
                'id_status'            => $applicant->id_status,
                'id_status_label'      => $applicant->id_status_label,
                'id_status_badge'      => $applicant->id_status_badge,
                'verification_status'  => $applicant->verification_status,
                'verification_label'   => $applicant->verification_status_label,
                'verification_badge'   => $applicant->verification_status_badge,
                'verified_by'          => $applicant->verified_by,
                'verified_at'          => $applicant->verified_at?->format('M d, Y h:i A'),
                'remarks'              => $applicant->remarks,
                'created_at'           => $applicant->created_at?->format('M d, Y h:i A'),
                'consent_given'        => $applicant->consent_given,
            ],
        ]);
    }

    /**
     * Mark applicant as verified.
     */
    public function verify(Request $request, int $id): JsonResponse
    {
        $applicant = Applicant::findOrFail($id);

        $applicant->update([
            'verification_status' => 'verified',
            'verified_by'         => $request->input('verified_by', 'Administrator'),
            'verified_at'         => now(),
            'remarks'             => $request->input('remarks'),
        ]);

        $emailSent = $this->sendApplicantNotification($applicant, 'applicant_approved');

        $message = 'Applicant has been verified successfully.';
        if ($emailSent === true) {
            $message .= ' Notification email sent.';
        } elseif ($emailSent === false) {
            $message .= ' Notification email could not be sent.';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    /**
     * Reject an applicant with remarks.
     */
    public function reject(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'remarks' => 'required|string|max:1000',
        ]);

        $applicant = Applicant::findOrFail($id);

        $applicant->update([
            'verification_status' => 'rejected',
            'verified_by'         => $request->input('verified_by', 'Administrator'),
            'verified_at'         => now(),
            'remarks'             => $request->input('remarks'),
        ]);

        $emailSent = $this->sendApplicantNotification($applicant, 'applicant_rejected');

        $message = 'Applicant has been rejected.';
        if ($emailSent === true) {
            $message .= ' Notification email sent.';
        } elseif ($emailSent === false) {
            $message .= ' Notification email could not be sent.';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    /**
     * Delete an applicant and their uploaded ID.
     */
    public function destroy(int $id): JsonResponse
    {
        $applicant = Applicant::findOrFail($id);

        if ($applicant->identification_path && Storage::disk('public')->exists($applicant->identification_path)) {
            Storage::disk('public')->delete($applicant->identification_path);
        }

        $applicant->delete();

        return response()->json([
            'success' => true,
            'message' => 'Applicant has been deleted successfully.',
        ]);
    }

    /**
     * Download the uploaded identification file.
     */
    public function downloadId(int $id): StreamedResponse|\Illuminate\Http\RedirectResponse
    {
        $applicant = Applicant::findOrFail($id);

        if (!$applicant->identification_path || !Storage::disk('public')->exists($applicant->identification_path)) {
            abort(404, 'Identification file not found.');
        }

        $filename = 'ID_' . $applicant->id . '_' . $applicant->last_name . '.' . pathinfo($applicant->identification_path, PATHINFO_EXTENSION);

        return Storage::disk('public')->download($applicant->identification_path, $filename);
    }

    /**
     * Render and send a templated notification email to the applicant.
     *
     * @return bool|null  true = sent, false = failed, null = skipped (no email / inactive template)
     */
    protected function sendApplicantNotification(Applicant $applicant, string $templateSlug): ?bool
    {
        if (empty($applicant->email)) {
            return null;
        }

        $renderer = app(EmailTemplateRenderer::class);
        $rendered = $renderer->renderForApplicant($templateSlug, $applicant);

        if ($rendered === null) {
            // Template missing or inactive
            return null;
        }

        try {
            Mail::to($applicant->email)->send(
                new TemplatedMail($rendered['subject'], $rendered['body'])
            );

            return true;
        } catch (\Throwable $e) {
            report($e);

            return false;
        }
    }
}
