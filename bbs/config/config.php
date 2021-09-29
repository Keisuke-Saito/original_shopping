<?php
ini_set('display_errors',1);
define('DSN','mysql:host=localhost;charset=utf8;dbname=bbs');
define('DB_USERNAME','root');
define('DB_PASSWORD','yuunama2');
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/bbs/public_html');
require_once(__DIR__ .'/../lib/Controller/functions.php');
require_once(__DIR__ . '/autoload.php');
session_start();
$current_uri = $_SERVER["REQUEST_URI"];
$file_name = basename($current_uri);
if(strpos($file_name, 'login.php') !== false || strpos($file_name,'signup.php') !== false || strpos($file_name,'index.php') !== false || strpos($file_name,'public_html') !== false) {
  // URL内のファイル名がlogin.php,signup.php,index.php(public_html)の時
}
else {
  // それ以外の時
  if(!isset($_SESSION['me'])) {
    header('Location: ' . SITE_URL . '/login.php');
    exit();
  }
}