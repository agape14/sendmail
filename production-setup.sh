#!/bin/bash

echo "🚀 CONFIGURACIÓN DE PRODUCCIÓN - Bot Consultas MYPE"
echo "════════════════════════════════════════════════════"

# Verificar que estamos en el directorio correcto
if [ ! -f "artisan" ]; then
    echo "❌ Error: No se encuentra artisan. Ejecuta desde el directorio del proyecto."
    exit 1
fi

echo "📦 [1/4] Instalando dependencias..."
composer install --no-dev --optimize-autoloader

echo "🔑 [2/4] Configurando aplicación..."
if [ ! -f ".env" ]; then
    cp env.example .env
    echo "✅ Archivo .env creado"
fi

php artisan key:generate --force
echo "✅ Clave de aplicación generada"

echo "🗄️ [3/4] Configurando base de datos..."
if [ ! -f "database/database.sqlite" ]; then
    touch database/database.sqlite
    echo "✅ Base de datos SQLite creada"
fi

php artisan migrate --force
php artisan db:seed --force
echo "✅ Base de datos inicializada con 15 preguntas"

echo "🧹 [4/4] Optimizando para producción..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
echo "✅ Caché optimizado"

echo ""
echo "✅ INSTALACIÓN COMPLETADA"
echo "════════════════════════════"
echo ""
echo "📧 CONFIGURACIÓN SMTP2GO:"
echo "  Host: mail.smtp2go.com"
echo "  Puerto: 2525"
echo "  FROM: consultas@sendmail.delacruzdev.tech"
echo ""
echo "🎯 COMANDOS DISPONIBLES:"
echo "  php artisan mype:send-consulta --force  # Envío manual"
echo "  php artisan mype:stats                  # Ver estadísticas"
echo "  php artisan mype:reset-questions        # Resetear preguntas"
echo ""
echo "📅 CRON JOB PARA HOSTINGER:"
echo "  0 10 20,21,22 09 * /usr/local/bin/php /home/tu-usuario/public_html/sendmail/artisan mype:send-consulta --force"
echo ""
echo "🎉 ¡Bot listo para enviar consultas automáticamente!"
