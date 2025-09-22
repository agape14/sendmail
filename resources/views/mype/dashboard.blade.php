<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bot de Consultas MYPE - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .dashboard-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            transition: transform 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            color: #ffffff;
        }
        .stat-label {
            font-size: 1.1rem;
            opacity: 1;
            color: #ffffff;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }
        .btn-custom {
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
        }
        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
        }
        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        .btn-danger-custom {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
            border: none;
            color: white;
        }
        .btn-danger-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        }
        .alert-custom {
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .config-section {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            border-radius: 20px;
            padding: 2rem;
            margin-top: 2rem;
            border: 2px solid rgba(52, 152, 219, 0.3);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            position: relative;
            overflow: hidden;
        }
        .config-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #3498db, #2ecc71, #f39c12, #e74c3c);
        }
        .config-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            border-radius: 10px;
            margin-bottom: 0.5rem;
        }
        .config-item:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(5px);
        }
        .config-item:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .config-label {
            font-weight: 600;
            color: #ecf0f1;
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .config-value {
            color: #2c3e50;
            font-family: 'Courier New', monospace;
            font-weight: 600;
            background: linear-gradient(135deg, #ecf0f1 0%, #bdc3c7 100%);
            padding: 0.5rem 1rem;
            border-radius: 25px;
            border: 2px solid #3498db;
            box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
            transition: all 0.3s ease;
            min-width: 120px;
            text-align: center;
        }
        .config-value:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.5);
        }
    </style>
</head>
<body>
    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header -->
                <div class="text-center mb-5">
                    <h1 class="text-white display-4 fw-bold mb-3">
                        <i class="fas fa-robot me-3"></i>
                        Bot de Consultas MYPE
                    </h1>
                    <p class="text-white-50 fs-5">Panel de Control y Gestión</p>
                </div>

                <!-- Alertas manejadas por SweetAlert2 -->

                <!-- Estadísticas Principales -->
                <div class="row mb-5">
                    <div class="col-md-3">
                        <div class="stat-card text-center">
                            <div class="stat-number">{{ $totalQuestions }}</div>
                            <div class="stat-label">
                                <i class="fas fa-question-circle me-2"></i>
                                Total Preguntas
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card text-center">
                            <div class="stat-number text-success">{{ $sentQuestions }}</div>
                            <div class="stat-label">
                                <i class="fas fa-check-circle me-2"></i>
                                Enviadas
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card text-center">
                            <div class="stat-number text-warning">{{ $pendingQuestions }}</div>
                            <div class="stat-label">
                                <i class="fas fa-clock me-2"></i>
                                Pendientes
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stat-card text-center">
                            <div class="stat-number text-info">
                                @if($lastSent)
                                    {{ \Carbon\Carbon::parse($lastSent->sent_at)->format('d/m') }}
                                @else
                                    --
                                @endif
                            </div>
                            <div class="stat-label">
                                <i class="fas fa-calendar me-2"></i>
                                Último Envío
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Panel de Control -->
                <div class="dashboard-card p-4 mb-4">
                    <h3 class="text-center mb-4">
                        <i class="fas fa-cogs me-2"></i>
                        Panel de Control
                    </h3>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <button id="sendConsultaBtn" class="btn btn-primary-custom btn-custom w-100">
                                <i class="fas fa-paper-plane me-2"></i>
                                Enviar Consulta Manual
                            </button>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button id="resetQuestionsBtn" class="btn btn-danger-custom btn-custom w-100">
                                <i class="fas fa-undo me-2"></i>
                                Resetear Preguntas
                            </button>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <button id="refreshStatsBtn" class="btn btn-outline-primary btn-custom w-100">
                                <i class="fas fa-sync-alt me-2"></i>
                                Actualizar Estadísticas
                            </button>
                        </div>
                        <div class="col-md-6 mb-3">
                            <button id="viewConfigBtn" class="btn btn-outline-secondary btn-custom w-100">
                                <i class="fas fa-cog me-2"></i>
                                Ver Configuración
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Configuración Actual -->
                <div class="dashboard-card p-4">
                    <div class="text-center mb-4">
                        <h4 class="mb-3 text-dark fw-bold">
                            <i class="fas fa-cogs me-2 text-primary"></i>
                            Configuración Actual del Sistema
                        </h4>
                        <p class="text-muted mb-0">Parámetros y configuraciones del Bot MYPE</p>
                    </div>
                    
                    <div class="config-section">
                        <div class="config-item">
                            <span class="config-label">
                                <i class="fas fa-envelope text-info me-2"></i>
                                Email Destino
                            </span>
                            <span class="config-value">{{ $config['target_email'] ?? 'No configurado' }}</span>
                        </div>
                        <div class="config-item">
                            <span class="config-label">
                                <i class="fas fa-user text-success me-2"></i>
                                Nombre Remitente
                            </span>
                            <span class="config-value">{{ $config['sender_name'] ?? 'No configurado' }}</span>
                        </div>
                        <div class="config-item">
                            <span class="config-label">
                                <i class="fas fa-clock text-warning me-2"></i>
                                Días Mínimos
                            </span>
                            <span class="config-value">{{ $config['min_days'] ?? 'No configurado' }}</span>
                        </div>
                        <div class="config-item">
                            <span class="config-label">
                                <i class="fas fa-clock text-warning me-2"></i>
                                Días Máximos
                            </span>
                            <span class="config-value">{{ $config['max_days'] ?? 'No configurado' }}</span>
                        </div>
                        <div class="config-item">
                            <span class="config-label">
                                <i class="fas fa-server text-primary me-2"></i>
                                Mailer
                            </span>
                            <span class="config-value">{{ $config['mail_mailer'] ?? 'No configurado' }}</span>
                        </div>
                        <div class="config-item">
                            <span class="config-label">
                                <i class="fas fa-at text-info me-2"></i>
                                From Address
                            </span>
                            <span class="config-value">{{ $config['mail_from_address'] ?? 'No configurado' }}</span>
                        </div>
                        <div class="config-item">
                            <span class="config-label">
                                <i class="fas fa-tag text-success me-2"></i>
                                From Name
                            </span>
                            <span class="config-value">{{ $config['mail_from_name'] ?? 'No configurado' }}</span>
                        </div>
                        <div class="config-item">
                            <span class="config-label">
                                <i class="fas fa-globe text-primary me-2"></i>
                                SMTP Host
                            </span>
                            <span class="config-value">{{ $config['mail_host'] ?? 'No configurado' }}</span>
                        </div>
                        <div class="config-item">
                            <span class="config-label">
                                <i class="fas fa-plug text-warning me-2"></i>
                                SMTP Puerto
                            </span>
                            <span class="config-value">{{ $config['mail_port'] ?? 'No configurado' }}</span>
                        </div>
                        <div class="config-item">
                            <span class="config-label">
                                <i class="fas fa-sun text-warning me-2"></i>
                                Horario Mínimo
                            </span>
                            <span class="config-value">{{ $config['send_hours_min'] ?? 'No configurado' }}:00</span>
                        </div>
                        <div class="config-item">
                            <span class="config-label">
                                <i class="fas fa-moon text-info me-2"></i>
                                Horario Máximo
                            </span>
                            <span class="config-value">{{ $config['send_hours_max'] ?? 'No configurado' }}:00</span>
                        </div>
                        <div class="config-item">
                            <span class="config-label">
                                <i class="fas fa-file-alt text-success me-2"></i>
                                Logging Detallado
                            </span>
                            <span class="config-value">{{ $config['detailed_logging'] ? 'Activado' : 'Desactivado' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Cronograma de Envío -->
                <div class="dashboard-card p-4 mt-4">
                    <h4 class="mb-3">
                        <i class="fas fa-calendar-alt me-2"></i>
                        Cronograma de Envío Automático
                    </h4>
                    
                    <div class="alert alert-info alert-custom">
                        <h6><i class="fas fa-info-circle me-2"></i>Próximos Envíos Programados:</h6>
                        <ul class="mb-0">
                            <li><strong>Sábado 21 Sept:</strong> 5 consultas (09:00, 11:00, 13:00, 15:00, 17:00 UTC)</li>
                            <li><strong>Domingo 22 Sept:</strong> 5 consultas (10:00, 12:00, 14:00, 16:00, 18:00 UTC)</li>
                            <li><strong>Lunes 23 Sept:</strong> 5 consultas (09:00, 11:00, 13:00, 15:00, 17:00 UTC)</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Funciones de utilidad con SweetAlert2
        function showAlert(message, type = 'info') {
            const config = {
                title: type === 'success' ? '¡Éxito!' : 
                       type === 'error' || type === 'danger' ? '¡Error!' : 
                       type === 'warning' ? '¡Advertencia!' : 'Información',
                text: message,
                icon: type === 'success' ? 'success' : 
                      type === 'error' || type === 'danger' ? 'error' : 
                      type === 'warning' ? 'warning' : 'info',
                confirmButtonText: 'Entendido',
                confirmButtonColor: type === 'success' ? '#28a745' : 
                                   type === 'error' || type === 'danger' ? '#dc3545' : 
                                   type === 'warning' ? '#ffc107' : '#17a2b8',
                timer: type === 'success' ? 3000 : null,
                timerProgressBar: true
            };
            
            Swal.fire(config);
        }

        // Función para actualizar estadísticas sin recargar página
        function updateStats() {
            fetch('/mype/stats')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Parsear las estadísticas del output
                    const output = data.output;
                    
                    const totalMatch = output.match(/Total de preguntas: (\d+)/);
                    const sentMatch = output.match(/Preguntas enviadas: (\d+)/);
                    const pendingMatch = output.match(/Preguntas pendientes: (\d+)/);
                    const lastSentMatch = output.match(/Último envío: (.+)/);
                    
                    // Actualizar cada tarjeta de estadística
                    const statCards = document.querySelectorAll('.stat-card');
                    
                    if (totalMatch && statCards[0]) {
                        statCards[0].querySelector('.stat-number').textContent = totalMatch[1];
                    }
                    if (sentMatch && statCards[1]) {
                        statCards[1].querySelector('.stat-number').textContent = sentMatch[1];
                    }
                    if (pendingMatch && statCards[2]) {
                        statCards[2].querySelector('.stat-number').textContent = pendingMatch[1];
                    }
                    if (lastSentMatch && statCards[3]) {
                        statCards[3].querySelector('.stat-number').textContent = lastSentMatch[1];
                    }
                }
            })
            .catch(error => {
                console.error('Error actualizando estadísticas:', error);
            });
        }

        // Enviar consulta manual
        document.getElementById('sendConsultaBtn').addEventListener('click', function() {
            Swal.fire({
                title: '¿Enviar consulta?',
                text: '¿Estás seguro de enviar una consulta manual?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#28a745',
                cancelButtonColor: '#dc3545',
                confirmButtonText: 'Sí, enviar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (!result.isConfirmed) return;
                
                // Deshabilitar botón inmediatamente
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Enviando...';
                
                // Crear una nueva petición con timeout
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 segundos
                
                fetch('/mype/send-consulta', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    signal: controller.signal
                })
                .then(response => response.json())
                .then(data => {
                    clearTimeout(timeoutId);
                    if (data.success) {
                        showAlert('✅ ' + data.message, 'success');
                        // Actualizar estadísticas después de un breve delay
                        setTimeout(() => {
                            updateStats();
                        }, 1000);
                    } else {
                        showAlert('❌ ' + data.message, 'danger');
                    }
                })
                .catch(error => {
                    clearTimeout(timeoutId);
                    if (error.name === 'AbortError') {
                        showAlert('⏰ La operación fue cancelada por timeout. Intenta nuevamente.', 'warning');
                    } else {
                        showAlert('❌ Error: ' + error.message, 'danger');
                    }
                })
                .finally(() => {
                    // Rehabilitar botón
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Enviar Consulta Manual';
                });
            });
        });

        // Resetear preguntas
        document.getElementById('resetQuestionsBtn').addEventListener('click', function() {
            Swal.fire({
                title: '¿Resetear preguntas?',
                text: '¿Estás seguro de resetear todas las preguntas? Esto marcará todas como no enviadas.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, resetear',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (!result.isConfirmed) return;
                
                // Deshabilitar botón inmediatamente
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Reseteando...';
                
                // Crear una nueva petición con timeout
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 10000); // 10 segundos
                
                fetch('/mype/reset-questions', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    signal: controller.signal
                })
                .then(response => response.json())
                .then(data => {
                    clearTimeout(timeoutId);
                    if (data.success) {
                        showAlert('✅ ' + data.message, 'success');
                        updateStats();
                    } else {
                        showAlert('❌ ' + data.message, 'danger');
                    }
                })
                .catch(error => {
                    clearTimeout(timeoutId);
                    if (error.name === 'AbortError') {
                        showAlert('⏰ La operación fue cancelada por timeout. Intenta nuevamente.', 'warning');
                    } else {
                        showAlert('❌ Error: ' + error.message, 'danger');
                    }
                })
                .finally(() => {
                    // Rehabilitar botón
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-undo me-2"></i>Resetear Preguntas';
                });
            });
        });

        // Actualizar estadísticas
        document.getElementById('refreshStatsBtn').addEventListener('click', function() {
            // Cambiar el texto del botón para mostrar que está actualizando
            const originalText = this.innerHTML;
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Actualizando...';
            
            updateStats();
            
            // Rehabilitar botón después de 2 segundos
            setTimeout(() => {
                this.disabled = false;
                this.innerHTML = originalText;
            }, 2000);
        });

        // Ver configuración con fallback
        document.getElementById('viewConfigBtn').addEventListener('click', function() {
            // Intentar primero el endpoint principal
            fetch('/mype/config')
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    showConfigModal(data.config);
                } else {
                    throw new Error(data.message || 'Error en la respuesta');
                }
            })
            .catch(error => {
                console.log('Endpoint principal falló, intentando endpoint de respaldo...', error);
                // Intentar endpoint de respaldo
                return fetch('/api/config')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        showConfigModal(data.config);
                    } else {
                        throw new Error(data.message || 'Error en la respuesta de respaldo');
                    }
                });
            })
            .catch(error => {
                console.error('Ambos endpoints fallaron:', error);
                showAlert('❌ Error al obtener configuración: ' + error.message + '. Verifica que el servidor esté funcionando correctamente.', 'danger');
            });
        });

        function showConfigModal(config) {
            let configText = '📋 Configuración del Bot:\n\n';
            Object.entries(config).forEach(([key, value]) => {
                configText += `${key}: ${value}\n`;
            });
            
            Swal.fire({
                title: 'Configuración del Bot',
                text: configText,
                icon: 'info',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#17a2b8'
            });
        }
    </script>
</body>
</html>
