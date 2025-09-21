<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuración del Bot de Consultas MYPE
    |--------------------------------------------------------------------------
    |
    | Esta configuración define los parámetros específicos para el bot
    | de envío automático de consultas sobre el proceso electoral MYPE.
    |
    */

    'target_email' => env('MYPE_TARGET_EMAIL', 'Eleccionescomprasamyperu@produce.gob.pe'),
    
    'sender_name' => env('MYPE_SENDER_NAME', 'Consultas MYPE'),
    
    'min_days_between_emails' => env('MYPE_MIN_DAYS_BETWEEN_EMAILS', 1),
    
    'max_days_between_emails' => env('MYPE_MAX_DAYS_BETWEEN_EMAILS', 7),
    
    'admin_email' => env('MYPE_ADMIN_EMAIL', env('MAIL_FROM_ADDRESS')),

    /*
    |--------------------------------------------------------------------------
    | Configuración de Horarios
    |--------------------------------------------------------------------------
    |
    | Define las horas en que pueden enviarse los correos automáticamente
    |
    */
    'send_hours' => [
        'min' => 9,  // 9:00 AM
        'max' => 17, // 5:00 PM
    ],

    /*
    |--------------------------------------------------------------------------
    | Configuración de Logging
    |--------------------------------------------------------------------------
    |
    | Define si se deben guardar logs detallados de los envíos
    |
    */
    'detailed_logging' => env('MYPE_DETAILED_LOGGING', true),
];
