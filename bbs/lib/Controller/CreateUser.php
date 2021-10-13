<?php
namespace Bbs\Controller;
class CreateUser extends \Bbs\Controller {
  public function run() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->newCreateUser();
    }
  }

  protected function newCreateUser() {
    try {
      $this->validate();
    } catch (\Bbs\Exception\InvalidName $e) {
      $this->setErrors('username', $e->getMessage());
    } catch (\Bbs\Exception\InvalidPassword $e) {
      $this->setErrors('password', $e->getMessage());
    } catch (\Bbs\Exception\InvalidEmail $e) {
      $this->setErrors('email', $e->getMessage());
    } catch (\Bbs\Exception\InvalidNumber $e) {
      $this->setErrors('authority', $e->getMessage());
    } catch (\Bbs\Exception\InvalidNumber $e) {
      $this->setErrors('delflag', $e->getMessage());
    }
    if ($this->hasError()) {
      return;
    }
    try {
      $newUser = new \Bbs\Model\User();
      $newUser->createUser([
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        'email' => $_POST['email'],
        'image' => $_POST['image'],
        'authority' => $_POST['authority'],
        'delflag' => $_POST['delflag'],
      ]);
    } catch (\Bbs\Exception\DuplicateEmail $e) {
      $this->setErrors('email', $e->getMessage());
      return;
    }
    header('Location: '. SITE_URL . '/admin-users.php');
    exit();
  }


  private function validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "不正なトークンです!";
      exit();
    }
    if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) {
      throw new \Bbs\Exception\InvalidEmail("メールアドレスが不正です!");
    }
    if ($_POST['username'] === '') {
      throw new \Bbs\Exception\InvalidName("ユーザー名が入力されていません!");
    }
    if ($_POST['authority'] != 1 && $_POST['authority'] != 99) {
      throw new \Bbs\Exception\InvalidNumber("「権限」に正しい値を入力してください!");
    }
    if ($_POST['delflag'] != 0 && $_POST['delflag'] != 1) {
      throw new \Bbs\Exception\InvalidNumber("「削除フラグ」に正しい値を入力してください!");
    }
  }
}