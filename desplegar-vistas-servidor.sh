#!/bin/bash

# Script específico para desplegar las vistas en el servidor de producción
# Ejecutar desde el directorio raíz del proyecto LOCAL

echo "=== DESPLIEGUE DE VISTAS AL SERVIDOR ==="
echo ""

# Configuración del servidor (AJUSTAR SEGÚN TU SERVIDOR)
SERVER_USER="u926438338"
SERVER_HOST="delacruzdev.tech"
SERVER_PATH="/home/u926438338/domains/delacruzdev.tech/public_html/sendmail"

echo "📋 PASO 1: Verificar archivos locales"
echo "=================================="

# Verificar que los archivos existen localmente
if [ ! -f "resources/views/mype/dashboard-fallback.blade.php" ]; then
    echo "❌ ERROR: No se encontró dashboard-fallback.blade.php"
    exit 1
fi

if [ ! -f "resources/views/mype/dashboard.blade.php" ]; then
    echo "⚠️  ADVERTENCIA: No se encontró dashboard.blade.php (opcional)"
else
    echo "✅ dashboard.blade.php encontrado"
fi

echo "✅ dashboard-fallback.blade.php encontrado"
echo ""

echo "📋 PASO 2: Crear directorio en el servidor"
echo "=========================================="

# Crear directorio de vistas en el servidor
ssh $SERVER_USER@$SERVER_HOST "mkdir -p $SERVER_PATH/resources/views/mype"
echo "✅ Directorio de vistas creado en el servidor"
echo ""

echo "📋 PASO 3: Subir archivos al servidor"
echo "===================================="

# Subir vista de respaldo (CRÍTICA)
echo "Subiendo vista de respaldo..."
scp resources/views/mype/dashboard-fallback.blade.php $SERVER_USER@$SERVER_HOST:$SERVER_PATH/resources/views/mype/
if [ $? -eq 0 ]; then
    echo "✅ dashboard-fallback.blade.php subido correctamente"
else
    echo "❌ ERROR al subir dashboard-fallback.blade.php"
    exit 1
fi

# Subir vista principal si existe
if [ -f "resources/views/mype/dashboard.blade.php" ]; then
    echo "Subiendo vista principal..."
    scp resources/views/mype/dashboard.blade.php $SERVER_USER@$SERVER_HOST:$SERVER_PATH/resources/views/mype/
    if [ $? -eq 0 ]; then
        echo "✅ dashboard.blade.php subido correctamente"
    else
        echo "⚠️  ADVERTENCIA: Error al subir dashboard.blade.php"
    fi
fi
echo ""

echo "📋 PASO 4: Ejecutar comandos en el servidor"
echo "=========================================="

# Ejecutar comandos en el servidor
ssh $SERVER_USER@$SERVER_HOST << 'EOF'
cd /home/u926438338/domains/delacruzdev.tech/public_html/sendmail

echo "Limpiando cache..."
php artisan view:clear
php artisan config:clear
php artisan cache:clear

echo "Verificando vistas..."
php artisan mype:verify-views

echo "Configurando permisos..."
chmod -R 755 resources/views/
chmod -R 755 storage/

echo "Optimizando para producción..."
php artisan config:cache
php artisan route:cache

echo "✅ Comandos ejecutados en el servidor"
EOF

echo ""
echo "📋 PASO 5: Verificar funcionamiento"
echo "=================================="

echo "Probando la URL..."
curl -I https://sendmail.delacruzdev.tech/mype/dashboard

echo ""
echo "🎉 DESPLIEGUE COMPLETADO"
echo "======================="
echo ""
echo "✅ Vista de respaldo desplegada"
echo "✅ Cache limpiado y optimizado"
echo "✅ Permisos configurados"
echo ""
echo "🌐 Visita: https://sendmail.delacruzdev.tech/mype/dashboard"
echo ""
echo "Si aún ves JSON, espera 1-2 minutos y recarga la página"
