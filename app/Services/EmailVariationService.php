<?php

namespace App\Services;

class EmailVariationService
{
    private static $greetings = [
        "Estimados señores del Programa Nacional Compras a MYPErú,",
        "Distinguidos representantes del Programa Nacional Compras a MYPErú,",
        "Cordial saludo a los responsables del Programa Nacional Compras a MYPErú,",
        "Muy buenos días, señores del Programa Nacional Compras a MYPErú,",
        "Reciban un cordial saludo del Programa Nacional Compras a MYPErú,",
    ];

    private static $introductions = [
        "Reciban un cordial saludo. Por medio del presente correo, me dirijo a ustedes con la finalidad de solicitar información y aclarar algunas dudas que tenemos respecto al proceso electoral para elegir representantes de los gremios de las MYPE.",
        "Espero se encuentren bien. Me pongo en contacto con ustedes para solicitar orientación sobre algunos aspectos del proceso electoral de representantes de gremios MYPE que no nos quedan del todo claros.",
        "Por medio de la presente, me permito contactarlos para solicitar información detallada sobre el proceso electoral de representantes de los gremios de las MYPE, ya que tenemos algunas inquietudes al respecto.",
        "Mediante este correo, deseo expresarles nuestro interés en participar activamente en el proceso electoral de representantes MYPE, por lo que necesitamos aclarar ciertas dudas procedimentales.",
        "Me dirijo a ustedes de manera respetuosa para solicitar información específica sobre el proceso electoral que se llevará a cabo para elegir representantes de los gremios MYPE.",
    ];

    private static $questionIntros = [
        "Específicamente, nos gustaría conocer lo siguiente:",
        "En particular, necesitamos saber:",
        "Nuestra consulta específica es:",
        "La duda que tenemos es la siguiente:",
        "Quisiéramos que nos aclaren:",
        "Necesitamos información sobre:",
    ];

    private static $justifications = [
        [
            "text" => "Esta información es de vital importancia para nuestro gremio, ya que deseamos participar de manera adecuada en este proceso electoral y cumplir con todos los requisitos establecidos.",
            "context" => "participación"
        ],
        [
            "text" => "Consideramos fundamental contar con esta información para poder tomar las decisiones correctas en beneficio de nuestros asociados y del sector MYPE en general.",
            "context" => "decisiones"
        ],
        [
            "text" => "Esta clarificación nos permitirá orientar mejor a nuestros miembros y asegurar una participación efectiva en el proceso electoral.",
            "context" => "orientación"
        ],
        [
            "text" => "Necesitamos esta información para poder cumplir adecuadamente con nuestras responsabilidades como representantes del gremio y brindar la orientación correcta a nuestros asociados.",
            "context" => "responsabilidades"
        ],
        [
            "text" => "Esta aclaración es importante para nosotros, ya que queremos asegurar que nuestro gremio participe de manera informada y responsable en este importante proceso.",
            "context" => "informada"
        ],
        [
            "text" => "Contar con esta información nos ayudará a preparar mejor a nuestro gremio para una participación exitosa en el proceso electoral.",
            "context" => "preparación"
        ],
    ];

    private static $closings = [
        "Agradecemos de antemano su gentil atención a nuestra solicitud y quedamos a la espera de su pronta respuesta para poder proceder según corresponda.",
        "Les agradecemos por su tiempo y esperamos contar con su valiosa orientación para continuar con nuestros procedimientos internos.",
        "Quedamos muy agradecidos por la atención que puedan brindar a nuestra consulta y esperamos su pronta respuesta.",
        "Agradecemos su colaboración y esperamos que puedan proporcionarnos la información solicitada a la brevedad posible.",
        "Les expresamos nuestro agradecimiento anticipado por su atención y esperamos su respuesta para poder avanzar en nuestros procesos internos.",
        "Valoramos mucho su tiempo y esperamos contar con su orientación para tomar las mejores decisiones para nuestro gremio.",
    ];

    public static function generateVariation(int $questionNumber): array
    {
        // Usar el número de pregunta para generar variaciones consistentes pero diferentes
        $greetingIndex = $questionNumber % count(self::$greetings);
        $introIndex = $questionNumber % count(self::$introductions);
        $questionIntroIndex = $questionNumber % count(self::$questionIntros);
        $justificationIndex = $questionNumber % count(self::$justifications);
        $closingIndex = $questionNumber % count(self::$closings);

        return [
            'greeting' => self::$greetings[$greetingIndex],
            'introduction' => self::$introductions[$introIndex],
            'question_intro' => self::$questionIntros[$questionIntroIndex],
            'justification' => self::$justifications[$justificationIndex]['text'],
            'closing' => self::$closings[$closingIndex],
        ];
    }

    public static function getRandomVariation(): array
    {
        return [
            'greeting' => self::$greetings[array_rand(self::$greetings)],
            'introduction' => self::$introductions[array_rand(self::$introductions)],
            'question_intro' => self::$questionIntros[array_rand(self::$questionIntros)],
            'justification' => self::$justifications[array_rand(self::$justifications)]['text'],
            'closing' => self::$closings[array_rand(self::$closings)],
        ];
    }
}
