<?php
/**
 * Script para verificar las rutas de Laravel
 * Ejecutar: php check-routes.php
 */

echo "🔍 Verificando rutas de Laravel...\n\n";

// Verificar que el archivo de rutas existe
$routesFile = __DIR__ . '/routes/web.php';
if (file_exists($routesFile)) {
    echo "✅ Archivo de rutas encontrado: $routesFile\n";
    echo "📄 Contenido del archivo de rutas:\n";
    echo "----------------------------------------\n";
    echo file_get_contents($routesFile);
    echo "\n----------------------------------------\n\n";
} else {
    echo "❌ Archivo de rutas NO encontrado: $routesFile\n";
}

// Verificar que el controlador existe
$controllerFile = __DIR__ . '/app/Http/Controllers/MyPeController.php';
if (file_exists($controllerFile)) {
    echo "✅ Controlador encontrado: $controllerFile\n";
} else {
    echo "❌ Controlador NO encontrado: $controllerFile\n";
}

// Verificar que las vistas existen
$dashboardView = __DIR__ . '/resources/views/mype/dashboard.blade.php';
$fallbackView = __DIR__ . '/resources/views/mype/dashboard-fallback.blade.php';

if (file_exists($dashboardView)) {
    echo "✅ Vista principal encontrada: $dashboardView\n";
} else {
    echo "❌ Vista principal NO encontrada: $dashboardView\n";
}

if (file_exists($fallbackView)) {
    echo "✅ Vista de respaldo encontrada: $fallbackView\n";
} else {
    echo "❌ Vista de respaldo NO encontrada: $fallbackView\n";
}

// Verificar configuración
$configFile = __DIR__ . '/config/mype.php';
if (file_exists($configFile)) {
    echo "✅ Configuración MYPE encontrada: $configFile\n";
} else {
    echo "❌ Configuración MYPE NO encontrada: $configFile\n";
}

echo "\n🚀 Comandos para ejecutar en el servidor:\n";
echo "1. php artisan route:list\n";
echo "2. php artisan route:clear\n";
echo "3. php artisan config:clear\n";
echo "4. php artisan cache:clear\n";
echo "5. php artisan optimize:clear\n";
echo "6. php artisan serve --host=0.0.0.0 --port=8000\n";
