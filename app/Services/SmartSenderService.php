<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;

class SmartSenderService
{
    /**
     * Mantiene Gmail pero configura headers para mostrar sender
     */
    public static function configureSenderEmail(array $sender): void
    {
        // Con SMTP2GO usar email verificado pero nombre del sender
        if (config('mail.mailers.smtp.host') === 'mail.smtp2go.com') {
            Config::set([
                'mail.from.address' => 'consultas@sendmail.delacruzdev.tech', // Email verificado
                'mail.from.name' => $sender['name'] . ' - ' . $sender['organization'], // Nombre del sender
                // Mantener credenciales SMTP2GO
                'mail.mailers.smtp.username' => env('MAIL_USERNAME'),
                'mail.mailers.smtp.password' => env('MAIL_PASSWORD')
            ]);
        } else {
            // Fallback para otros proveedores
            $naturalName = $sender['name'] . ' de ' . $sender['organization'];
            Config::set([
                'mail.from.address' => env('MAIL_FROM_ADDRESS'),
                'mail.from.name' => $naturalName,
                'mail.mailers.smtp.username' => env('MAIL_USERNAME'),
                'mail.mailers.smtp.password' => env('MAIL_PASSWORD')
            ]);
        }
    }

    /**
     * Restaura la configuración original
     */
    public static function restoreOriginalConfig(): void
    {
        Config::set([
            'mail.from.address' => env('MAIL_FROM_ADDRESS'),
            'mail.from.name' => env('MAIL_FROM_NAME'),
            'mail.mailers.smtp.username' => env('MAIL_USERNAME'),
            'mail.mailers.smtp.password' => env('MAIL_PASSWORD')
        ]);
    }
}
