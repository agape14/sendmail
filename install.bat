@echo off
echo ========================================
echo   Bot de Consultas MYPE - Instalacion
echo ========================================
echo.

echo [1/5] Copiando archivo de configuracion...
if not exist .env (
    copy env.example .env
    echo ✓ Archivo .env creado
) else (
    echo ! Archivo .env ya existe
)

echo.
echo [2/5] Instalando dependencias de Composer...
composer install --no-dev --optimize-autoloader
if %errorlevel% neq 0 (
    echo ✗ Error instalando dependencias
    pause
    exit /b 1
)

echo.
echo [3/5] Generando clave de aplicacion...
php artisan key:generate --force
if %errorlevel% neq 0 (
    echo ✗ Error generando clave
    pause
    exit /b 1
)

echo.
echo [4/5] Creando base de datos...
if not exist database\database.sqlite (
    type nul > database\database.sqlite
    echo ✓ Base de datos SQLite creada
)

echo.
echo [5/5] Ejecutando migraciones y seeders...
php artisan migrate --seed --force
if %errorlevel% neq 0 (
    echo ✗ Error en migraciones
    pause
    exit /b 1
)

echo.
echo ========================================
echo   ¡Instalacion Completada!
echo ========================================
echo.
echo Comandos disponibles:
echo   php artisan mype:send-consulta  - Enviar consulta manual
echo   php artisan mype:stats          - Ver estadisticas
echo   php artisan mype:reset-questions - Resetear preguntas
echo.
echo No olvides configurar tu .env con:
echo   - Credenciales SMTP
echo   - MYPE_TARGET_EMAIL
echo   - MYPE_SENDER_NAME
echo.
pause
