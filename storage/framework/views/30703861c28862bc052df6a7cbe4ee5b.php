<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
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
        .button {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            margin: 10px 5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }
        .button:active {
            transform: translateY(0);
        }
        .button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        .button.stats {
            background: linear-gradient(45deg, #4834d4, #686de0);
        }
        .result-box {
            background: rgba(0, 0, 0, 0.3);
            padding: 15px;
            border-radius: 10px;
            margin: 15px 0;
            border-left: 4px solid #00d2d3;
            display: none;
        }
        .result-box.success {
            border-left-color: #00d2d3;
        }
        .result-box.error {
            border-left-color: #ff6b6b;
        }
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
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
            <div style="text-align: center; margin: 20px 0;">
                <button class="button" onclick="sendConsulta()" id="sendBtn">
                    📧 Enviar Consulta
                </button>
                <button class="button stats" onclick="getStats()" id="statsBtn">
                    📊 Ver Estadísticas
                </button>
            </div>
            <div id="resultBox" class="result-box"></div>
            <ul>
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

    <script>
        function showLoading(buttonId) {
            const button = document.getElementById(buttonId);
            const originalText = button.innerHTML;
            button.innerHTML = '<span class="loading"></span> Procesando...';
            button.disabled = true;
            return originalText;
        }

        function hideLoading(buttonId, originalText) {
            const button = document.getElementById(buttonId);
            button.innerHTML = originalText;
            button.disabled = false;
        }

        function showResult(message, isSuccess = true) {
            const resultBox = document.getElementById('resultBox');
            resultBox.innerHTML = message;
            resultBox.className = `result-box ${isSuccess ? 'success' : 'error'}`;
            resultBox.style.display = 'block';
            
            // Auto-hide after 10 seconds
            setTimeout(() => {
                resultBox.style.display = 'none';
            }, 10000);
        }

        function sendConsulta() {
            const originalText = showLoading('sendBtn');
            
            fetch('/mype/send-consulta', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                }
            })
            .then(response => response.json())
            .then(data => {
                hideLoading('sendBtn', originalText);
                if (data.success) {
                    showResult(`✅ ${data.message}<br><br><strong>Salida del comando:</strong><br><pre style="background: rgba(0,0,0,0.3); padding: 10px; border-radius: 5px; margin-top: 10px; white-space: pre-wrap;">${data.output}</pre>`, true);
                } else {
                    showResult(`❌ ${data.message}`, false);
                }
            })
            .catch(error => {
                hideLoading('sendBtn', originalText);
                showResult(`❌ Error de conexión: ${error.message}`, false);
            });
        }

        function getStats() {
            const originalText = showLoading('statsBtn');
            
            fetch('/mype/stats')
            .then(response => response.json())
            .then(data => {
                hideLoading('statsBtn', originalText);
                if (data.success) {
                    showResult(`📊 ${data.message}<br><br><strong>Estadísticas:</strong><br><pre style="background: rgba(0,0,0,0.3); padding: 10px; border-radius: 5px; margin-top: 10px; white-space: pre-wrap;">${data.output}</pre>`, true);
                } else {
                    showResult(`❌ ${data.message}`, false);
                }
            })
            .catch(error => {
                hideLoading('statsBtn', originalText);
                showResult(`❌ Error de conexión: ${error.message}`, false);
            });
        }
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\sendmail\resources\views/welcome.blade.php ENDPATH**/ ?>