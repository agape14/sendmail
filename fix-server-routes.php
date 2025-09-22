<?php
/**
 * Script para diagnosticar y solucionar problemas de rutas en el servidor
 * Ejecutar: php fix-server-routes.php
 */

echo "🔧 Diagnosticando y solucionando problemas de rutas en el servidor...\n\n";

// 1. Verificar archivos esenciales
echo "1. Verificando archivos esenciales:\n";
$files = [
    'routes/web.php',
    'app/Http/Controllers/MyPeController.php',
    'config/mype.php',
    'resources/views/mype/dashboard.blade.php',
    'resources/views/mype/dashboard-fallback.blade.php'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "✅ $file - OK\n";
    } else {
        echo "❌ $file - FALTANTE\n";
    }
}

echo "\n2. Limpiando caché de Laravel:\n";
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
    echo "Resultado: " . trim($output) . "\n";
}

echo "\n3. Verificando rutas registradas:\n";
$routeList = shell_exec('php artisan route:list 2>&1');
echo $routeList;

echo "\n4. URLs para probar:\n";
echo "🔗 Dashboard principal: https://sendmail.delacruzdev.tech/\n";
echo "🔗 Test de rutas: https://sendmail.delacruzdev.tech/test-routes\n";
echo "🔗 Configuración principal: https://sendmail.delacruzdev.tech/mype/config\n";
echo "🔗 Configuración de respaldo: https://sendmail.delacruzdev.tech/api/config\n";
echo "🔗 Estadísticas: https://sendmail.delacruzdev.tech/mype/stats\n";

echo "\n5. Comandos de diagnóstico:\n";
echo "curl -I https://sendmail.delacruzdev.tech/\n";
echo "curl https://sendmail.delacruzdev.tech/test-routes\n";
echo "curl https://sendmail.delacruzdev.tech/api/config\n";

echo "\n6. Si el problema persiste, verificar:\n";
echo "- Configuración del servidor web (Apache/Nginx)\n";
echo "- Archivo .htaccess en public/\n";
echo "- Permisos de archivos\n";
echo "- Logs del servidor web\n";

echo "\n✅ Script completado. Prueba las URLs arriba.\n";
