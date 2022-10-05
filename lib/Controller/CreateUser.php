<?php
namespace Shopping\Controller;
class CreateUser extends \Shopping\Controller {
  public function run() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->newCreateUser();
    }
  }

  protected function newCreateUser() {
    try {
      $this->validate();
    } catch (\Shopping\Exception\InvalidName $e) {
      $this->setErrors('username', $e->getMessage());
    } catch (\Shopping\Exception\InvalidEmail $e) {
      $this->setErrors('email', $e->getMessage());
    } catch (\Shopping\Exception\InvalidPassword $e) {
      $this->setErrors('password', $e->getMessage());
    } catch (\Shopping\Exception\InvalidNumber $e) {
      $this->setErrors('authority', $e->getMessage());
    } catch (\Shopping\Exception\InvalidNumber $e) {
      $this->setErrors('delflag', $e->getMessage());
    }
    if ($this->hasError()) {
      return;
    }
    try {
      $newUser = new \Shopping\Model\User();
      $newUser->createUser([
        'username' => $_POST['username'],
        'email' => $_POST['email'],
        'password' => $_POST['password'],
        'authority' => $_POST['authority'],
        'delflag' => $_POST['delflag']
      ]);
    } catch (\Shopping\Exception\DuplicateEmail $e) {
      $this->setErrors('email', $e->getMessage());
      return;
    }
    header('Location: '. SITE_URL . '/admin_users.php');
    exit();
  }

  private function validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "不正なトークンです!";
      exit();
    }
    if ($_POST['username'] === '') {
      throw new \Shopping\Exception\InvalidName("ユーザー名が入力されていません!");
    }
    if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
      throw new \Shopping\Exception\InvalidEmail("メールアドレスが不正です!");
    }
    if ($_POST['authority'] != 1 && $_POST['authority'] != 99) {
      throw new \Shopping\Exception\InvalidNumber("”権限”には「1」か「99」を入力してください!");
    }
    if ($_POST['delflag'] != 0 && $_POST['delflag'] != 1) {
      throw new \Shopping\Exception\InvalidNumber("”削除フラグ”には「0」か「1」を入力してください!");
    }
  }
}