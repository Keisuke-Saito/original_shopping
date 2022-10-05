<?php
namespace Shopping\Controller;
class UserDelete extends \Shopping\Controller {
  public function run() {
    $user = new \Shopping\Model\User();
    $userData = $user->find($_SESSION['me']->id);
    $this->setValues('username', $userData->username);
    $this->setValues('email', $userData->email);
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['type']) == 'delete') {
      if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
        echo "不正なトークンです!";
        exit();
      }

    $userModel = new \Shopping\Model\User();
    $userModel->delete();

    $_SESSION = [];

    if (isset($_COOKIE[session_name()])) {
      setcookie(session_name(), '', time()-86400, '/');
    }

    session_destroy();

    header('Location: ' . SITE_URL . '/index.php');
    exit();
    }
  }
}