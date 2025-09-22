# 🤖 Bot de Consultas MYPE

Sistema automatizado para enviar consultas sobre el proceso electoral de representantes de MYPE de manera aleatoria y programada.

## 📋 Descripción

Este bot Laravel envía automáticamente las 15 consultas específicas sobre el proceso electoral de representantes de MYPE al correo `Eleccionescomprasamyperu@produce.gob.pe` en intervalos aleatorios entre 1 y 7 días.

## ✨ Características

- ✅ **15 preguntas predefinidas** sobre el proceso electoral MYPE
- 🎲 **Envío aleatorio** en intervalos configurables (1-7 días)
- 📧 **Correos HTML profesionales** con formato personalizado
- 🔄 **Sistema de rotación** que resetea automáticamente cuando se envían todas las preguntas
- 📊 **Estadísticas y monitoreo** del estado del bot
- 🕒 **Scheduler integrado** para envíos automáticos
- 📝 **Logging detallado** de todos los envíos

## 🚀 Instalación

### 1. Requisitos Previos
- PHP 8.2 o superior
- Composer
- SQLite (incluido por defecto)

### 2. Instalación de Dependencias
```bash
composer install
```

### 3. Configuración del Entorno
```bash
# Copiar archivo de configuración
copy env.example .env

# Generar clave de aplicación
php artisan key:generate
```

### 4. Configurar Variables de Entorno
Edita el archivo `.env` y configura:

```env
# Configuración de correo SMTP (ejemplo con Gmail)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-contraseña-de-aplicacion
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@mypeconsultas.com"
MAIL_FROM_NAME="MYPE Consultas Bot"

# Configuración específica del bot
MYPE_TARGET_EMAIL=Eleccionescomprasamyperu@produce.gob.pe
MYPE_SENDER_NAME="Consultas MYPE"
MYPE_MIN_DAYS_BETWEEN_EMAILS=1
MYPE_MAX_DAYS_BETWEEN_EMAILS=7
```

### 5. Inicializar Base de Datos
```bash
php artisan migrate --seed
```

## 🎯 Uso

### 🌐 **Interfaz Web (Recomendado)**

Accede a: `https://sendmail.delacruzdev.tech/`

**Funcionalidades de la interfaz web:**
- 📊 **Dashboard completo** con estadísticas en tiempo real
- 🚀 **Envío manual** de consultas con un clic
- 🔄 **Reset de preguntas** para reiniciar el bot
- ⚙️ **Configuración** del bot
- 📅 **Cronograma** de envíos automáticos
- 📱 **Diseño responsive** para móviles

### 💻 **Comandos de Consola**

#### Enviar Consulta Manual
```bash
php artisan mype:send-consulta --force
```
Envía inmediatamente una consulta aleatoria.

#### Ver Estadísticas
```bash
php artisan mype:stats
```
Muestra el estado actual del bot y estadísticas de envío.

#### Resetear Estado de Preguntas
```bash
php artisan mype:reset-questions
```
Marca todas las preguntas como no enviadas para reiniciar el ciclo.

#### Envío Programado (Automático)
```bash
php artisan mype:scheduled-send
```
Comando interno usado por el scheduler para envíos automáticos.

### ⏰ **Configuración del Cron Job en Hostinger**

**Para el Sábado 21 Septiembre:**
```
0 14,16,18,20,22 21 09 6 /usr/local/bin/php /home/u926438338/public_html/sendmail/artisan mype:send-consulta --force
```

**Para el Domingo 22 Septiembre:**
```
0 15,17,19,21,23 22 09 0 /usr/local/bin/php /home/u926438338/public_html/sendmail/artisan mype:send-consulta --force
```

**Para el Lunes 23 Septiembre:**
```
0 14,16,18,20,22 23 09 1 /usr/local/bin/php /home/u926438338/public_html/sendmail/artisan mype:send-consulta --force
```

## 📧 Configuración de Correo

### SMTP2GO (Configurado)
El sistema está configurado para usar SMTP2GO:
- **Host**: mail.smtp2go.com
- **Puerto**: 2525
- **FROM**: consultas@sendmail.delacruzdev.tech (verificado)
- **Límite**: 1,000 emails gratis/mes

### Configuración en .env
```env
MAIL_MAILER=smtp
MAIL_HOST=mail.smtp2go.com
MAIL_PORT=2525
MAIL_USERNAME=tu-username-smtp2go
MAIL_PASSWORD=tu-password-smtp2go
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=consultas@sendmail.delacruzdev.tech
```

## 📋 Las 15 Consultas

El sistema incluye las siguientes consultas predefinidas:

1. ¿Cuál es el objetivo principal del procedimiento de elección de representantes de los gremios de las MYPE?
2. ¿Qué sectores productivos están comprendidos en el procedimiento de elección?
3. ¿Quién convoca públicamente a la elección de los representantes de los gremios de las MYPE?
4. ¿Qué funciones tiene el Comité Electoral en el proceso de elección?
5. ¿Cuáles son los requisitos para que una Asociación de MYPE o Comité de MYPE pueda inscribirse como elector?
6. ¿Cuáles son los requisitos para que un candidato pueda postularse como representante del gremio de MYPE?
7. ¿Cómo se realiza la presentación y resolución de tachas contra candidatos durante el proceso electoral?
8. ¿Cuáles son las modalidades de votación permitidas en el proceso electoral y cómo se garantiza la confidencialidad del voto?
9. ¿Qué sucede en caso de empate entre gremios de las MYPE en la elección de representantes?
10. ¿Cuáles son las causales para declarar nulo o desierto el proceso de elección?
11. En el caso de que nuestra asociación no esté inscrita en el RENAMYPE, quisiéramos saber si aún podemos participar y qué condiciones adicionales debemos cumplir.
12. Agradeceríamos nos aclaren cuál es el número mínimo de socios que debe tener nuestro gremio para poder inscribirse en este proceso electoral.
13. También deseamos conocer qué documentos específicos debemos presentar para que nuestra inscripción sea aceptada y en qué formato se deben entregar.
14. Qué sucederá en caso no haya suficientes candidatos inscritos o si durante la votación se produce un empate entre los gremios.
15. Finalmente, pedimos que nos informen por cuánto tiempo durarán en el cargo los representantes elegidos y cuáles serán sus principales responsabilidades dentro de los Núcleos Ejecutores de Compras.

## 🔧 Configuración Avanzada

### Variables de Entorno Adicionales

```env
# Email de administrador para notificaciones de error
MYPE_ADMIN_EMAIL=admin@tudominio.com

# Logging detallado (true/false)
MYPE_DETAILED_LOGGING=true
```

### Personalización de Horarios

El bot está configurado para verificar envíos a las 10:00 AM. Para cambiar esto, edita `app/Console/Kernel.php`:

```php
$schedule->command('mype:scheduled-send')
    ->dailyAt('14:00') // Cambiar a 2:00 PM
```

## 📊 Monitoreo

### Logs
Los logs se almacenan en:
- `storage/logs/mype-bot.log` - Logs de envío
- `storage/logs/mype-stats.log` - Logs de estadísticas
- `storage/logs/laravel.log` - Logs generales

### Dashboard Web
Visita `http://tu-dominio.com` para ver el dashboard del bot con información del estado actual.

## 🛠️ Solución de Problemas

### Error: "No se ha configurado el email de destino"
Asegúrate de que `MYPE_TARGET_EMAIL` esté configurado en tu archivo `.env`.

### Error de autenticación SMTP
1. Verifica las credenciales SMTP
2. Para Gmail, asegúrate de usar una "Contraseña de aplicación"
3. Verifica que el puerto y cifrado sean correctos

### No se envían correos automáticamente
1. Verifica que el cron job esté configurado correctamente
2. Revisa los logs en `storage/logs/`
3. Ejecuta manualmente: `php artisan mype:scheduled-send`

## 📝 Licencia

Este proyecto está bajo la Licencia MIT.

## 🤝 Contribuciones

Las contribuciones son bienvenidas. Por favor, crea un issue antes de enviar un pull request.

---

**Desarrollado para automatizar consultas sobre el proceso electoral de representantes de MYPE** 🇵🇪
