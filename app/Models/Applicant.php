<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Applicant extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    /**
     * Mass assignable attributes.
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
        'consent_given',
        'ip_address',
        'verification_status',
        'id_status',
        'verified_by',
        'verified_at',
        'remarks',
        'verification_uuid',
        'verification_hash',
    ];

    /**
     * Attribute casting.
     */
    protected $casts = [
        'consent_given' => 'boolean',
        'verified_at'   => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Media Collections
    |--------------------------------------------------------------------------
    */

    public function registerMediaCollections(): void
    {
        // Applicant uploaded ID
        $this
            ->addMediaCollection('identification')
            ->singleFile();

        // Generated QR Code
        $this
            ->addMediaCollection('verification_qr')
            ->singleFile();

        // Future use
        $this
            ->addMediaCollection('attachments');
    }

    /*
    |--------------------------------------------------------------------------
    | Media Conversions
    |--------------------------------------------------------------------------
    */

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->width(250)
            ->height(250)
            ->sharpen(10)
            ->performOnCollections(
                'identification',
                'verification_qr'
            );

        $this
            ->addMediaConversion('preview')
            ->width(1000)
            ->performOnCollections('identification');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getFullNameAttribute(): string
    {
        return trim(implode(' ', array_filter([
            "{$this->last_name},",
            $this->first_name,
            $this->middle_name,
            $this->suffix,
        ])));
    }

    public function getApplicantTypeLabelAttribute(): string
    {
        return match ($this->applicant_type) {
            'abuyognon'     => 'Abuyognon',
            'acc_student'   => 'ACC Student',
            'non_abuyognon' => 'Non-Abuyognon',
            default         => $this->applicant_type,
        };
    }

    public function getApplicantTypeBadgeAttribute(): string
    {
        return match ($this->applicant_type) {
            'abuyognon'     => 'primary',
            'acc_student'   => 'success',
            'non_abuyognon' => 'secondary',
            default         => 'secondary',
        };
    }

    public function getVerificationStatusLabelAttribute(): string
    {
        return match ($this->verification_status) {
            'pending'  => 'Pending',
            'verified' => 'Verified',
            'rejected' => 'Rejected',
            default    => ucfirst($this->verification_status),
        };
    }

    public function getVerificationStatusBadgeAttribute(): string
    {
        return match ($this->verification_status) {
            'pending'  => 'warning',
            'verified' => 'success',
            'rejected' => 'danger',
            default    => 'secondary',
        };
    }

    public function getIdStatusLabelAttribute(): string
    {
        return match ($this->id_status) {
            'uploaded'     => 'Uploaded',
            'missing'      => 'Missing',
            'needs_review' => 'Needs Review',
            default        => ucfirst(str_replace('_', ' ', $this->id_status)),
        };
    }

    public function getIdStatusBadgeAttribute(): string
    {
        return match ($this->id_status) {
            'uploaded'     => 'success',
            'missing'      => 'danger',
            'needs_review' => 'warning',
            default        => 'secondary',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Identification
    |--------------------------------------------------------------------------
    */

    public function getIdentificationMediaAttribute(): ?Media
    {
        return $this->getFirstMedia('identification');
    }

    public function getIdentificationUrlAttribute(): ?string
    {
        return $this->identification_media?->getUrl();
    }

    public function getIdentificationPreviewUrlAttribute(): ?string
    {
        return $this->identification_media?->getUrl('preview');
    }

    public function getIdentificationThumbUrlAttribute(): ?string
    {
        return $this->identification_media?->getUrl('thumb');
    }

    public function getIdentificationMimeTypeAttribute(): ?string
    {
        return $this->identification_media?->mime_type;
    }

    public function getIdentificationExtensionAttribute(): ?string
    {
        return $this->identification_media?->extension;
    }

    public function getIsIdentificationImageAttribute(): bool
    {
        return str_starts_with(
            $this->identification_media?->mime_type ?? '',
            'image/'
        );
    }

    public function getIsIdentificationPdfAttribute(): bool
    {
        return $this->identification_media?->mime_type === 'application/pdf';
    }

    /*
    |--------------------------------------------------------------------------
    | Verification QR
    |--------------------------------------------------------------------------
    */

    public function getVerificationQrMediaAttribute(): ?Media
    {
        return $this->getFirstMedia('verification_qr');
    }

    public function getVerificationQrUrlAttribute(): ?string
    {
        return $this->verification_qr_media?->getUrl();
    }

    public function getVerificationQrThumbUrlAttribute(): ?string
    {
        return $this->verification_qr_media?->getUrl('thumb');
    }
}
