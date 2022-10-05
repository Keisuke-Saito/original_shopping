<?php
ini_set('display_errors',1);
define('DSN','mysql:host=localhost;charset=utf8;dbname=shopping');
define('DB_USERNAME','root');
define('DB_PASSWORD','yuunama2');
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . '/shopping/public_html');
require_once(__DIR__ .'/../lib/Controller/functions.php');
require_once(__DIR__ . '/autoload.php');
session_start();
$current_uri = $_SERVER["REQUEST_URI"];
$file_name = basename($current_uri);