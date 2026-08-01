<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class TemplatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $emailSubject,
        public string $emailBody,
        public ?Media $qrCode = null,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->emailSubject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.layout',
            with: [
                'subject'    => $this->emailSubject,
                'body'       => $this->emailBody,
                'systemName' => config('app.name'),
            ],
        );
    }

    public function attachments(): array
    {
        if (! $this->qrCode) {
            return [];
        }

        return [
            Attachment::fromPath($this->qrCode->getPath())
                ->as('Verification-QRCode.png')
                ->withMime('image/png'),
        ];
    }
}
