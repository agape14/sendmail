<?php
/**
 * Script para limpiar caché de Laravel en el servidor
 * Ejecutar: php clear-cache.php
 */

echo "🧹 Limpiando caché de Laravel...\n";

// Comandos para limpiar caché
$commands = [
    'php artisan route:clear',
    'php artisan config:clear', 
    'php artisan cache:clear',
    'php artisan view:clear',
    'php artisan optimize:clear'
];

foreach ($commands as $command) {
    echo "Ejecutando: $command\n";
    $output = shell_exec($command . ' 2>&1');
    echo "Resultado: " . $output . "\n";
}

echo "✅ Caché limpiado exitosamente\n";
echo "🔗 Prueba las siguientes URLs:\n";
echo "- https://sendmail.delacruzdev.tech/\n";
echo "- https://sendmail.delacruzdev.tech/test-routes\n";
echo "- https://sendmail.delacruzdev.tech/mype/config\n";
