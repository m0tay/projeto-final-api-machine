<?php
require_once '../config.php';
require_once '../core.php';

$pdo = connectDB($db);

try {
  $machine_id = $_ENV['MACHINE_ID'] ?? null;
  
  if (!$machine_id) {
    $code = 500;
    $response = ['message' => 'MACHINE_ID não configurado'];
  } else {
    $query = "
      SELECT b.* 
      FROM beverages b 
      JOIN machine_beverages mb ON b.id = mb.beverage_id 
      WHERE mb.machine_id = :machine_id 
        AND b.is_active = 1 
        AND mb.is_available = 1
      ORDER BY b.name ASC
    ";
    
    $stmt = $pdo->prepare($query);
    $stmt->execute(['machine_id' => $machine_id]);
    $beverages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($beverages) {
      $code = 200;
      $response = ['records' => $beverages];
    } else {
      $code = 404;
      $response = ['message' => 'Sem registros'];
    }
  }
} catch (Exception $e) {
  $code = 500;
  $response = ['message' => 'Erro ao buscar menu: ' . $e->getMessage()];
}

header('Content-Type: application/json; charset=UTF-8');
http_response_code($code);
echo json_encode($response);
die();
