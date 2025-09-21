<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.name')); ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.37);
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2.5em;
        }
        .info-box {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid #ffd700;
        }
        .commands {
            background: rgba(0, 0, 0, 0.2);
            padding: 15px;
            border-radius: 5px;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
        }
        .status {
            display: inline-block;
            padding: 5px 15px;
            background: rgba(0, 255, 0, 0.2);
            border-radius: 20px;
            font-size: 0.9em;
        }
        ul {
            list-style-type: none;
            padding-left: 0;
        }
        li {
            margin: 10px 0;
            padding: 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🤖 <?php echo e(config('app.name')); ?></h1>
        
        <div class="info-box">
            <h3>📧 Bot de Consultas Automáticas</h3>
            <p>Este sistema envía automáticamente las 15 consultas sobre el proceso electoral de representantes de MYPE al correo: <strong><?php echo e(config('mype.target_email')); ?></strong></p>
            <div class="status">✅ Sistema Activo</div>
        </div>

        <div class="info-box">
            <h3>⚙️ Comandos Disponibles</h3>
            <ul>
                <li>
                    <strong>Enviar consulta manual:</strong>
                    <div class="commands">php artisan mype:send-consulta</div>
                </li>
                <li>
                    <strong>Ver estadísticas:</strong>
                    <div class="commands">php artisan mype:stats</div>
                </li>
                <li>
                    <strong>Resetear preguntas:</strong>
                    <div class="commands">php artisan mype:reset-questions</div>
                </li>
                <li>
                    <strong>Inicializar base de datos:</strong>
                    <div class="commands">php artisan migrate --seed</div>
                </li>
            </ul>
        </div>

        <div class="info-box">
            <h3>🕒 Configuración de Envíos</h3>
            <p><strong>Intervalo:</strong> Entre <?php echo e(config('mype.min_days_between_emails')); ?> y <?php echo e(config('mype.max_days_between_emails')); ?> días</p>
            <p><strong>Horario:</strong> 10:00 AM (verificación diaria)</p>
            <p><strong>Remitente:</strong> <?php echo e(config('mype.sender_name')); ?></p>
        </div>

        <div class="info-box">
            <h3>🚀 Activar Bot Automático</h3>
            <p>Para activar el envío automático, configura el cron job en tu servidor:</p>
            <div class="commands">* * * * * cd /ruta/a/tu/proyecto && php artisan schedule:run >> /dev/null 2>&1</div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\laragon\www\sendmail\resources\views/welcome.blade.php ENDPATH**/ ?>