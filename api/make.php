<?php
require_once '../config.php';
require_once '../core.php';
require_once '../objects/Beverage.php';

$beverage = new Beverage($db);
$data = json_decode(file_get_contents('php://input'));

if (!isset($data->beverage_id)) {
  $code = 400;
  $response = ['message' => 'beverage_id é obrigatório'];
}

try {
  $beverage->id = $data->beverage_id;
  $beverage->read();
  
  if (!$beverage->id) {
    $code = 404;
    $response = ['message' => 'Bebida não encontrada'];
  } else if ($beverage->is_active == false) {
    $code = 422;
    $response = ['message' => 'Bebida indisponível'];
  } else {
    $beverage->make();
    $code = 200;
    $response = [
      'message' => 'Bebida preparada com sucesso',
      'beverage' => [
        'id' => $beverage->id,
        'name' => $beverage->name,
      ]
    ];
  }
  
} catch (Exception $e) {
  $code = 422;
  $response = ['message' => 'Não foi possível preparar a bebida'];
}

header('Content-Type: application/json; charset=UTF-8');
http_response_code($code);
echo json_encode($response);
die(); // https://stackoverflow.com/questions/4064444/returnin-json-from-a-php-script#comment88774427_4064468
