<?php
require_once '../config.php';
require_once '../core.php';

$pdo = connectDB($db);
$data = json_decode(file_get_contents('php://input'));

if (!isset($data->beverage_id)) {
  $code = 400;
  $response = ['message' => 'beverage_id é obrigatório'];
  header('Content-Type: application/json; charset=UTF-8');
  http_response_code($code);
  echo json_encode($response);
  die();
}

try {
  $stmt = $pdo->prepare("SELECT * FROM beverages WHERE id = :beverage_id AND is_available = 1");
  $stmt->bindValue(':beverage_id', $data->beverage_id);
  $stmt->execute();
  $beverage = $stmt->fetch();
  
  if (!$beverage) {
    $code = 404;
    $response = ['message' => 'Bebida não encontrada'];
  } else {
    $code = 200;
    $response = [
      'message' => 'Bebida preparada com sucesso',
      'beverage' => [
        'id' => $beverage['id'],
        'brew_time_seconds' => $beverage['brew_time_seconds']
      ]
    ];
  }
  
} catch (Exception $e) {
  $code = 500;
  $response = ['message' => 'Erro ao preparar bebida: ' . $e->getMessage()];
}

header('Content-Type: application/json; charset=UTF-8');
http_response_code($code);
echo json_encode($response);
die(); // https://stackoverflow.com/questions/4064444/returnin-json-from-a-php-script#comment88774427_4064468
