<?php
/**
 * Script para configurar el proyecto después de git pull
 * Ejecutar con: php setup-after-pull.php
 */

echo "=== CONFIGURANDO PROYECTO DESPUÉS DE GIT PULL ===\n";
echo "Ejecutando configuración automática...\n\n";

// Función para ejecutar comandos
function runCommand($command, $description) {
    echo "📋 $description\n";
    echo "Ejecutando: $command\n";
    
    $output = [];
    $returnCode = 0;
    exec($command . ' 2>&1', $output, $returnCode);
    
    if ($returnCode === 0) {
        echo "✅ Completado\n";
        if (!empty($output)) {
            echo "Salida: " . implode("\n", $output) . "\n";
        }
    } else {
        echo "❌ Error (código: $returnCode)\n";
        echo "Salida: " . implode("\n", $output) . "\n";
    }
    echo "\n";
}

// 1. Crear directorio mype si no existe
echo "📋 Creando directorio mype...\n";
if (!is_dir('resources/views/mype')) {
    mkdir('resources/views/mype', 0755, true);
    echo "✅ Directorio mype creado\n";
} else {
    echo "✅ Directorio mype ya existe\n";
}
echo "\n";

// 2. Verificar que el archivo dashboard-fallback.blade.php existe
echo "📋 Verificando vista de respaldo...\n";
if (file_exists('resources/views/mype/dashboard-fallback.blade.php')) {
    echo "✅ dashboard-fallback.blade.php encontrado\n";
} else {
    echo "⚠️  dashboard-fallback.blade.php no encontrado\n";
    echo "Necesitas subir este archivo manualmente\n";
}
echo "\n";

// 3. Configurar permisos
runCommand('chmod -R 755 resources/views/', 'Configurando permisos de vistas');
runCommand('chmod -R 755 storage/', 'Configurando permisos de storage');
runCommand('chmod -R 755 bootstrap/cache/', 'Configurando permisos de cache');

// 4. Limpiar cache
runCommand('php artisan view:clear', 'Limpiando cache de vistas');
runCommand('php artisan config:clear', 'Limpiando cache de configuración');
runCommand('php artisan cache:clear', 'Limpiando cache general');
runCommand('php artisan route:clear', 'Limpiando cache de rutas');

// 5. Optimizar para producción
runCommand('php artisan config:cache', 'Cacheando configuración');
runCommand('php artisan route:cache', 'Cacheando rutas');

// 6. Verificar estructura
runCommand('php artisan mype:verify-views', 'Verificando estructura de vistas');

echo "🎉 CONFIGURACIÓN COMPLETADA\n";
echo "===========================\n";
echo "✅ Directorio mype creado\n";
echo "✅ Permisos configurados\n";
echo "✅ Cache limpiado y optimizado\n";
echo "✅ Aplicación optimizada para producción\n";
echo "\n🌐 Prueba la URL: https://sendmail.delacruzdev.tech/\n";
echo "Ahora deberías ver la interfaz visual en lugar del JSON\n";
?>
