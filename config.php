<?php
require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = ['path' => __DIR__ . '/' . $_ENV['DB_FILENAME']];

define('API_MODULES', explode(',', $_ENV['API_MODULES']));

define('DEBUG', filter_var($_ENV['DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN));
if (DEBUG) {
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
}
