#!/bin/bash

# Script específico para desplegar en el servidor de producción
# Ejecutar desde el directorio raíz del proyecto en el servidor

echo "=== Despliegue en Servidor de Producción ==="

# Verificar que estamos en el directorio correcto
if [ ! -f "artisan" ]; then
    echo "ERROR: No se encontró el archivo artisan. Asegúrate de estar en el directorio raíz del proyecto."
    exit 1
fi

echo "✓ Directorio del proyecto verificado"

# Crear directorio de vistas si no existe
echo "=== Verificando estructura de vistas ==="
mkdir -p resources/views/mype
mkdir -p resources/views/emails

echo "✓ Directorios de vistas creados/verificados"

# Verificar archivos críticos
echo "=== Verificando archivos críticos ==="

CRITICAL_FILES=(
    "app/Http/Controllers/MyPeController.php"
    "resources/views/mype/dashboard.blade.php"
    "resources/views/mype/dashboard-fallback.blade.php"
    "resources/views/emails/mype-consulta.blade.php"
)

for file in "${CRITICAL_FILES[@]}"; do
    if [ -f "$file" ]; then
        echo "✓ $file existe"
    else
        echo "⚠️  $file NO existe - será necesario subirlo"
    fi
done

# Limpiar cache
echo "=== Limpiando cache ==="
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan route:clear

echo "✓ Cache limpiado"

# Verificar permisos
echo "=== Configurando permisos ==="
chmod -R 755 resources/views/
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

echo "✓ Permisos configurados"

# Optimizar para producción
echo "=== Optimizando para producción ==="
php artisan config:cache
php artisan route:cache

# Solo cachear vistas si existen
if [ -f "resources/views/mype/dashboard.blade.php" ]; then
    php artisan view:cache
    echo "✓ Cache de vistas creado"
else
    echo "⚠️  No se pudo cachear vistas - archivo principal no encontrado"
fi

echo "✓ Aplicación optimizada"

# Verificar que el comando funciona
echo "=== Verificando comandos ==="
php artisan mype:verify-views

echo "=== Despliegue completado ==="
echo ""
echo "INSTRUCCIONES FINALES:"
echo "1. Si faltan archivos, súbelos manualmente al servidor"
echo "2. Verifica que la ruta /mype/dashboard funcione"
echo "3. Si persisten errores, revisa los logs en storage/logs/"
echo ""
echo "Para verificar el funcionamiento:"
echo "curl -I http://tu-dominio.com/mype/dashboard"
