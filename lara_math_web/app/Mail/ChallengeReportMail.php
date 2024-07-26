<?php

namespace App\Mail;

use App\Models\Challenge;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

// class for handling mail with necessary constructors
class ChallengeReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $challenge;
    protected $pdfPath;

    public function __construct($challenge, $pdfPath)
    {
        $this->challenge = $challenge;
        $this->pdfPath = $pdfPath;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Challenge Report Mail',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.challenge_report',
        );
    }

    public function attachments(): array
    {
        return [];
    }

    public function build()
    {
        return $this->subject('Challenge Report')
                    ->markdown('emails.challenge_report')
                    ->attach($this->pdfPath);
    }
}
