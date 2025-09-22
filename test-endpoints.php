<?php
/**
 * Script para probar todos los endpoints del dashboard
 * Ejecutar: php test-endpoints.php
 */

echo "🧪 Probando todos los endpoints del dashboard...\n\n";

$baseUrl = 'https://sendmail.delacruzdev.tech';
$endpoints = [
    'GET /' => 'Dashboard principal',
    'GET /test-routes' => 'Test de rutas',
    'GET /api/config' => 'Configuración',
    'GET /api/stats' => 'Estadísticas',
    'POST /api/send-consulta' => 'Enviar consulta',
    'POST /api/reset-questions' => 'Resetear preguntas'
];

foreach ($endpoints as $endpoint => $description) {
    echo "🔗 Probando: $endpoint - $description\n";
    
    $url = $baseUrl . str_replace('GET ', '', str_replace('POST ', '', $endpoint));
    $method = strpos($endpoint, 'POST') === 0 ? 'POST' : 'GET';
    
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
            }
        } else {
            echo "⚠️  No es JSON válido (puede ser HTML)\n";
            echo "Primeros 100 caracteres: " . substr($response, 0, 100) . "...\n";
        }
    } else {
        echo "❌ HTTP $httpCode - Error\n";
        echo "Respuesta: " . substr($response, 0, 200) . "...\n";
    }
    
    echo "\n";
}

echo "🎯 URLs para probar manualmente:\n";
echo "Dashboard: $baseUrl/\n";
echo "Test rutas: $baseUrl/test-routes\n";
echo "Configuración: $baseUrl/api/config\n";
echo "Estadísticas: $baseUrl/api/stats\n";

echo "\n✅ Pruebas completadas.\n";
