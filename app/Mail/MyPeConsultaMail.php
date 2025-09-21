<?php

namespace App\Mail;

use App\Models\Question;
use App\Services\SenderService;
use App\Services\EmailVariationService;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MyPeConsultaMail extends Mailable
{
    use Queueable, SerializesModels;

    public Question $question;
    public array $sender;

    public function __construct(Question $question, ?array $sender = null)
    {
        $this->question = $question;
        
        // Si no se proporciona un remitente, usar uno basado en el número de pregunta
        $this->sender = $sender ?? SenderService::getSenderByIndex($question->number);
    }

    public function envelope(): Envelope
    {
        // Para SMTP2GO: usar email verificado como FROM pero nombre del sender
        if (config('mail.mailers.smtp.host') === 'mail.smtp2go.com') {
            return new Envelope(
                subject: 'Consultas sobre el proceso electoral de representantes de MYPE',
                from: new Address('consultas@sendmail.delacruzdev.tech', $this->sender['name'] . ' - ' . $this->sender['organization']),
                replyTo: [new Address($this->sender['email'], $this->sender['name'])],
            );
        }
        
        // Para otros SMTP: usar email del sender
        return new Envelope(
            subject: 'Consultas sobre el proceso electoral de representantes de MYPE',
            from: new Address($this->sender['email'], $this->sender['name']),
            replyTo: [new Address($this->sender['email'], $this->sender['name'])],
        );
    }

    public function content(): Content
    {
        // Generar variación basada en el número de pregunta para consistencia
        $variation = EmailVariationService::generateVariation($this->question->number);
        
        return new Content(
            view: 'emails.mype-consulta',
            with: [
                'question' => $this->question,
                'senderName' => $this->sender['name'],
                'organization' => $this->sender['organization'],
                'phone' => $this->sender['phone'],
                'variation' => $variation,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
