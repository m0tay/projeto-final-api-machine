<?php
require_once 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = [
  'host' => $_ENV['DB_HOST'],
  'port' => $_ENV['DB_PORT'],
  'charset' => $_ENV['DB_CHARSET'],
  'dbname' => $_ENV['DB_NAME'],
  'username' => $_ENV['DB_USERNAME_DBO'],
  'password' => $_ENV['DB_PASSWORD_DBO']
];


define('API_MODULES', explode(',', $_ENV['API_MODULES']));

define('DEBUG', filter_var($_ENV['DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN));
if (DEBUG) {
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
}
