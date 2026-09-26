<?php

namespace App\Mail;

use App\Models\Enquiry;
use App\Models\LabSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EnquiryAutoReply extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Enquiry $enquiry,
        public LabSetting $lab,
        public ?string $pdfPath = null
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Thank you — we received your '.$this->enquiry->typeLabel().' ('.$this->enquiry->ref().')'
        );
    }

    public function content(): Content
    {
        return new Content(view: 'mail.enquiry-auto-reply');
    }

    public function attachments(): array
    {
        if ($this->pdfPath && is_file($this->pdfPath)) {
            return [
                Attachment::fromPath($this->pdfPath)
                    ->as($this->enquiry->ref().'.pdf')
                    ->withMime('application/pdf'),
            ];
        }
        return [];
    }
}
