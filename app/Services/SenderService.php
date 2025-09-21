<?php

namespace App\Services;

class SenderService
{
    private static $senders = [
        [
            'name' => 'Patricia Flores',
            'email' => 'patricia.flores.empresaria@gmail.com',
            'organization' => 'Asociación de Microempresarios del Norte',
            'phone' => '987-234-567'
        ],
        [
            'name' => 'Luis Torres',
            'email' => 'luistorres.negocios@hotmail.com',
            'organization' => 'Gremio de Pequeñas Empresas de Lima',
            'phone' => '956-345-678'
        ],
        [
            'name' => 'Miguel Castillo',
            'email' => 'miguel.castillo@yahoo.com',
            'organization' => 'Comité de MYPE del Sur',
            'phone' => '943-456-789'
        ],
        [
            'name' => 'Ana Vargas',
            'email' => 'ana.vargas.consultas@gmail.com',
            'organization' => 'Asociación de Emprendedores MYPE',
            'phone' => '972-567-890'
        ],
        [
            'name' => 'Patricia Ortiz',
            'email' => 'patricia.ortiz@outlook.com',
            'organization' => 'Federación de Microempresas',
            'phone' => '965-678-901'
        ],
        [
            'name' => 'Carmen Vargas',
            'email' => 'carmenvargas.representante@gmail.com',
            'organization' => 'Gremio Regional de MYPE',
            'phone' => '951-789-012'
        ],
        [
            'name' => 'Manuel Rodriguez',
            'email' => 'manuel.rodriguez@hotmail.com',
            'organization' => 'Consorcio de Pequeños Empresarios',
            'phone' => '938-890-123'
        ],
        [
            'name' => 'Rosa Lopez',
            'email' => 'rosa.lopez.gremio@yahoo.es',
            'organization' => 'Asociación de Mujeres Emprendedoras',
            'phone' => '974-901-234'
        ],
        [
            'name' => 'Ricardo Cruz',
            'email' => 'ricardo.cruz.comercial@gmail.com',
            'organization' => 'Cámara de Comercio MYPE',
            'phone' => '987-012-345'
        ],
        [
            'name' => 'Carmen Gonzalez',
            'email' => 'carmen.gonzalez@outlook.com',
            'organization' => 'Red de Microempresarios Peruanos',
            'phone' => '956-123-456'
        ],
        [
            'name' => 'Elena Rodriguez',
            'email' => 'elena.rodriguez.info@hotmail.com',
            'organization' => 'Asociación de Artesanos y MYPE',
            'phone' => '943-234-567'
        ],
        [
            'name' => 'Carlos Lopez',
            'email' => 'carloslopez@gmail.com',
            'organization' => 'Gremio de Comerciantes Minoristas',
            'phone' => '972-345-678'
        ],
        [
            'name' => 'Gloria Martinez',
            'email' => 'gloria.martinez.coordinacion@yahoo.com',
            'organization' => 'Federación de Pequeños Productores',
            'phone' => '965-456-789'
        ],
        [
            'name' => 'Jorge Flores',
            'email' => 'jorge.flores@gmail.com',
            'organization' => 'Asociación de Empresarios Emergentes',
            'phone' => '951-567-890'
        ],
        [
            'name' => 'Maria Gonzalez',
            'email' => 'maria.gonzalez.gerencia@hotmail.es',
            'organization' => 'Comité Regional de Microempresas',
            'phone' => '938-678-901'
        ]
    ];

    public static function getRandomSender(): array
    {
        return self::$senders[array_rand(self::$senders)];
    }

    public static function getSenderByIndex(int $index): array
    {
        $totalSenders = count(self::$senders);
        $senderIndex = $index % $totalSenders;
        return self::$senders[$senderIndex];
    }

    public static function getAllSenders(): array
    {
        return self::$senders;
    }
}