#!/bin/bash

# Script para verificar y desplegar las vistas en el servidor de producción
# Ejecutar desde el directorio raíz del proyecto

echo "=== Verificando estructura de vistas ==="

# Verificar que el directorio de vistas existe
if [ ! -d "resources/views" ]; then
    echo "ERROR: Directorio resources/views no existe"
    exit 1
fi

# Verificar que el directorio mype existe
if [ ! -d "resources/views/mype" ]; then
    echo "ERROR: Directorio resources/views/mype no existe"
    exit 1
fi

# Verificar que el archivo dashboard.blade.php existe
if [ ! -f "resources/views/mype/dashboard.blade.php" ]; then
    echo "ERROR: Archivo resources/views/mype/dashboard.blade.php no existe"
    exit 1
fi

echo "✓ Estructura de vistas correcta"

# Limpiar cache de vistas
echo "=== Limpiando cache de vistas ==="
php artisan view:clear
php artisan config:clear
php artisan cache:clear

echo "✓ Cache limpiado"

# Verificar permisos
echo "=== Verificando permisos ==="
chmod -R 755 resources/views/
chmod -R 755 storage/

echo "✓ Permisos configurados"

# Optimizar para producción
echo "=== Optimizando para producción ==="
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✓ Aplicación optimizada para producción"

echo "=== Despliegue completado ==="
echo "Las vistas deberían estar disponibles ahora."
