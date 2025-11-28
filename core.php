<?php
function connectDB($db) {
  try {
    $pdo = new PDO('sqlite:' . $db['path']);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec('PRAGMA foreign_keys = ON;');
    return $pdo;
  } catch (PDOException $e) {
    die('Database error: ' . $e->getMessage());
  }
}

function debug($info = '', $type = 'log') {
  if (defined('DEBUG') && DEBUG) {
    echo "<script>console.$type(" . json_encode($info, JSON_PRETTY_PRINT) . ");</script>";
    return true;
  }
  return false;
}

function debug_array($info = '') {
  if (defined('DEBUG') && DEBUG) {
    global $_DEBUG;
    $_DEBUG = $info;
    return true;
  }
  return false;
}

function get_path_module() {
  $pathinfo = filter_input(INPUT_SERVER, 'PATH_INFO');
  if (empty($pathinfo)) return false;
  $patharray = explode("/", $pathinfo);
  return in_array($patharray[1], API_MODULES) ? $patharray[1] : false;
}

function get_path_id() {
  $pathinfo = filter_input(INPUT_SERVER, 'PATH_INFO');
  if (empty($pathinfo)) return null;
  $patharray = explode("/", $pathinfo);
  if (isset($patharray[2]) && filter_var($patharray[2], FILTER_VALIDATE_INT)) {
    return (int)$patharray[2];
  }
  return null;
}

function is_admin() {
  return isset($_SESSION['email']) && $_SESSION['profile'] == 'admin';
}

