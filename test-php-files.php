<?php
/**
 * Script para probar los archivos PHP directos
 * Ejecutar: php test-php-files.php
 */

echo "🧪 Probando archivos PHP directos...\n\n";

$baseUrl = 'https://sendmail.delacruzdev.tech';
$files = [
    'api-config.php' => 'Configuración',
    'api-stats.php' => 'Estadísticas',
    'api-send-consulta.php' => 'Enviar consulta (POST)',
    'api-reset-questions.php' => 'Resetear preguntas (POST)'
];

foreach ($files as $file => $description) {
    echo "🔗 Probando: $file - $description\n";
    
    $url = $baseUrl . '/' . $file;
    $method = (strpos($file, 'send-consulta') !== false || strpos($file, 'reset-questions') !== false) ? 'POST' : 'GET';
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-Requested-With: XMLHttpRequest'
        ]);
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        echo "❌ Error cURL: $error\n";
    } elseif ($httpCode === 200) {
        echo "✅ HTTP $httpCode - OK\n";
        
        // Intentar parsear JSON
        $data = json_decode($response, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            echo "✅ JSON válido\n";
            if (isset($data['success'])) {
                echo "✅ Campo 'success' presente: " . ($data['success'] ? 'true' : 'false') . "\n";
                if (isset($data['message'])) {
                    echo "📝 Mensaje: " . $data['message'] . "\n";
                }
            }
        } else {
            echo "⚠️  No es JSON válido\n";
            echo "Primeros 100 caracteres: " . substr($response, 0, 100) . "...\n";
        }
    } else {
        echo "❌ HTTP $httpCode - Error\n";
        echo "Respuesta: " . substr($response, 0, 200) . "...\n";
    }
    
    echo "\n";
}

echo "🎯 URLs para probar manualmente:\n";
echo "Configuración: $baseUrl/api-config.php\n";
echo "Estadísticas: $baseUrl/api-stats.php\n";
echo "Enviar consulta: $baseUrl/api-send-consulta.php (POST)\n";
echo "Resetear preguntas: $baseUrl/api-reset-questions.php (POST)\n";

echo "\n✅ Pruebas completadas.\n";
