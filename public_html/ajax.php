<?php
require_once(__DIR__ . '/../config/config.php');
$productApp = new \Shopping\Model\Product();
if($_SERVER['REQUEST_METHOD'] === 'POST') {
  try {
    $res = $productApp->changeCartin([
      'product_id' => $_POST['product_id'],
      'quantity' => $_POST['quantity'],
      'user_id' => $_POST['user_id']
    ]);
    header('Content-Type: application/json');
    echo json_encode($res);
  } catch (Exception $e) {
    header($_SERVER['SERVER_PROTOCOL']. '500 Internal Server Error', true, 500);
    echo $e->getMessage();
  }
} else {
  header('Location: '. SITE_URL);
  exit();
}