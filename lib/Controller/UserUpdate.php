<?php
namespace Shopping\Controller;
class UserUpdate extends \Shopping\Controller {
  public function run() {
    $this->showUser();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // var_dump($_POST);
      // exit();
      $this->updateUser();
    }
  }

  protected function showUser() {
    $user = new \Shopping\Model\User();
    $userData = $user->find($_SESSION['me']->id);
    $this->setValues('username', $userData->username);
    $this->setValues('email', $userData->email);
  }

  protected function updateuser() {
    try {
      $this->validate();
    } catch (\Shopping\Exception\InvalidEmail $e) {
      $this->setErrors('email', $e->getMessage());
    } catch (\Shopping\Exception\InvalidName $e) {
      $this->setErrors('username', $e->getMessage());
    }
    $this->setValues('username', $_POST['username']);
    $this->setValues('email', $_POST['email']);
    if ($this->hasError()) {
      return;
    } else {
      try {
        $userModel = new \Shopping\Model\User();
        $userModel->update([
          'username' => $_POST['username'],
          'email' => $_POST['email']
        ]);
      }
      catch (\Shopping\Exception\DuplicatedEmail $e) {
        $this->setErrors('email', $e->getMessage());
        return;
      }
    }
    $_SESSION['me']->username = $_POST['username'];
    header('Location: '. SITE_URL . '/mypage.php');
    exit();
  }

  private function validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "不正なトークンです!";
      exit();
    }
    if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
      throw new \Shopping\Exception\InvalidEmail("メールアドレスが不正です!");
    }
    if ($_POST['username'] === '') {
      throw new \Shopping\Exception\InvalidName("ユーザー名が入力されていません!");
    }
  }
}