<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Applicant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'applicant_type',
        'last_name',
        'first_name',
        'middle_name',
        'suffix',
        'place_of_examination',
        'email',
        'contact_number',
        'identification_path',
        'consent_given',
        'ip_address',
        'verification_status',
        'id_status',
        'verified_by',
        'verified_at',
        'remarks',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'consent_given' => 'boolean',
        'verified_at'   => 'datetime',
    ];

    /**
     * Get the full name of the applicant.
     */
    public function getFullNameAttribute(): string
    {
        $parts = array_filter([
            $this->last_name . ',',
            $this->first_name,
            $this->middle_name,
            $this->suffix,
        ]);

        return implode(' ', $parts);
    }

    /**
     * Human-readable applicant type label.
     */
    public function getApplicantTypeLabelAttribute(): string
    {
        return match ($this->applicant_type) {
            'abuyognon'     => 'Abuyognon',
            'acc_student'   => 'ACC Student',
            'non_abuyognon' => 'Non-Abuyognon',
            default         => $this->applicant_type,
        };
    }

    /**
     * Bootstrap badge class for applicant type.
     */
    public function getApplicantTypeBadgeAttribute(): string
    {
        return match ($this->applicant_type) {
            'abuyognon'     => 'primary',
            'acc_student'   => 'success',
            'non_abuyognon' => 'secondary',
            default         => 'light',
        };
    }

    /**
     * Bootstrap badge class for verification status.
     */
    public function getVerificationStatusBadgeAttribute(): string
    {
        return match ($this->verification_status) {
            'pending'  => 'warning',
            'verified' => 'success',
            'rejected' => 'danger',
            default    => 'secondary',
        };
    }

    /**
     * Human-readable verification status.
     */
    public function getVerificationStatusLabelAttribute(): string
    {
        return match ($this->verification_status) {
            'pending'  => 'Pending',
            'verified' => 'Verified',
            'rejected' => 'Rejected',
            default    => ucfirst($this->verification_status),
        };
    }

    /**
     * Bootstrap badge class for ID status.
     */
    public function getIdStatusBadgeAttribute(): string
    {
        return match ($this->id_status) {
            'uploaded'     => 'success',
            'missing'      => 'danger',
            'needs_review' => 'warning',
            default        => 'secondary',
        };
    }

    /**
     * Human-readable ID status.
     */
    public function getIdStatusLabelAttribute(): string
    {
        return match ($this->id_status) {
            'uploaded'     => 'Uploaded',
            'missing'      => 'Missing',
            'needs_review' => 'Needs Review',
            default        => ucfirst(str_replace('_', ' ', $this->id_status)),
        };
    }

    /**
     * Public URL for the uploaded identification file.
     */
    public function getIdentificationUrlAttribute(): ?string
    {
        if (!$this->identification_path) {
            return null;
        }

        return Storage::disk('public')->url($this->identification_path);
    }

    /**
     * Whether the ID file is an image.
     */
    public function getIsIdentificationImageAttribute(): bool
    {
        if (!$this->identification_path) {
            return false;
        }

        $ext = strtolower(pathinfo($this->identification_path, PATHINFO_EXTENSION));

        return in_array($ext, ['jpg', 'jpeg', 'png'], true);
    }

    /**
     * Whether the ID file is a PDF.
     */
    public function getIsIdentificationPdfAttribute(): bool
    {
        if (!$this->identification_path) {
            return false;
        }

        return strtolower(pathinfo($this->identification_path, PATHINFO_EXTENSION)) === 'pdf';
    }
}
