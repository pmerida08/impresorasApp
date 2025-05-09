<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use App\Models\Impresora;

class LowTonerAlert extends Mailable
{
    use Queueable, SerializesModels;

    public $impresora;
    public $tonerLevels;

    /**
     * Create a new message instance.
     */
    public function __construct(Impresora $impresora, array $tonerLevels)
    {
        $this->impresora = $impresora;
        $this->tonerLevels = $tonerLevels;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Alerta: Nivel de Tóner Bajo',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.low-toner-alert',
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

    public function from($address = null, $name = null)
    {
        return new Address(
            $address ?? env('MAIL_FROM_ADDRESS', 'ceis.dpco.chap@juntadeandalucia.es'),
            $name ?? env('MAIL_FROM_NAME', 'Junta de Andalucía')
        );
    }
}
