<?php
require_once '../config.php';
require_once '../core.php';

$pdo = connectDB($db);

try {
  $stmt = $pdo->query("SELECT * FROM beverages WHERE is_active = 1 ORDER BY name ASC");
  $beverages = $stmt->fetchAll(PDO::FETCH_ASSOC);
  
  if ($beverages) {
    $code = 200;
    $response = ['records' => $beverages];
  } else {
    $code = 404;
    $response = ['message' => 'Sem registros'];
  }
} catch (Exception $e) {
  $code = 500;
  $response = ['message' => 'Erro ao buscar menu: ' . $e->getMessage()];
}

header('Content-Type: application/json; charset=UTF-8');
http_response_code($code);
echo json_encode($response);
die();
