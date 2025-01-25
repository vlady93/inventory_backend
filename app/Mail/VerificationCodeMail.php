<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $cuenta;
    protected $correlativo;
    protected $moneda;
    protected $monto;
    protected $fondoLabel;

    /**
     * Create a new message instance.
     */
    public function __construct($cuenta,$correlativo,$moneda,$monto,$fondoLabel)
    {
        $this->cuenta = $cuenta;
        $this->correlativo = $correlativo;
        $this->moneda = $moneda;
        $this->monto = $monto;
        $this->fondoLabel = $fondoLabel;
    }

    /**
     * Get the message envelope.
     */

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verification Code Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.verification',
            with: ['cuenta' => $this->cuenta,
            'correlativo' => $this->correlativo,
            'moneda' => $this->moneda,
            'monto' => $this->monto,
            'fondoLabel' => $this->fondoLabel
        ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
