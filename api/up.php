<?php
require_once '../config.php';
require_once '../core.php';

$pdo = connectDB($db);

try {
  $stmt = $pdo->query("SELECT COUNT(*) as count FROM beverages");
  $result = $stmt->fetch();

  $code = 200;
  $response = [
    'status' => 'healthy',
    'message' => 'Sistema operacional',
    'timestamp' => date('c'),
    'beverages_count' => $result['count']
  ];
} catch (Exception $e) {
  $code = 503;
  $response = ['message' => 'Sistema com problemas: ' . $e->getMessage()];
}

header('Content-Type: application/json; charset=UTF-8');
http_response_code($code);
echo json_encode($response);
die(); // https://stackoverflow.com/questions/4064444/returnin-json-from-a-php-script#comment88774427_4064468
