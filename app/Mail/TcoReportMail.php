<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;

class TcoReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $pdfData;
    private string $pdfContent;
    private string $namaFile;

    public function __construct(array $pdfData, string $pdfContent, string $namaFile)
    {
        $this->pdfData    = $pdfData;
        $this->pdfContent = $pdfContent;
        $this->namaFile   = $namaFile;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Kalkulasi TCO dari ' . $this->pdfData['nama'] . ' untuk ' . $this->pdfData['sales_name'],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.tco-report',
            with: ['data' => $this->pdfData],
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [
            Attachment::fromData(fn () => $this->pdfContent, $this->namaFile)
                ->withMime('application/pdf'),
        ];
    }
}
