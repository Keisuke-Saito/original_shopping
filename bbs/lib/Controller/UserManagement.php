<?php
namespace Bbs\Controller;
class UserManagement extends \Bbs\Controller {
  public function run() {
    if ($this->isLoggedIn()) {
      if ($_SESSION['me']->authority == 1) {
        header('Location:' . SITE_URL .'/thread_all.php');
        exit();
      }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      try {
        if (empty($_POST['data'])) {
          throw new \Bbs\Exception\EmptyPost("ユーザーを選択してください！");
        }
      } catch (\Bbs\Exception\EmptyPost $e) {
        $this->setErrors('data', $e->getMessage());
      }
      if ($this->hasError()) {
        return;
      }
      if (isset($_POST['delete'])) {
        $this->userDelete();
      } else {
        $this->managementUser();
      }
    }
  }

  public function getUsersAll() {
    $userAll = new \Bbs\Model\User();
    $users = $userAll->getUsersAll();
    return $users;
  }

  protected function managementUser() {
    $this->setValues('username', $_POST['username'.$_POST['data']]);
    $this->setValues('email', $_POST['email'.$_POST['data']]);
    $this->setValues('image', $_POST['image'.$_POST['data']]);
    $this->setValues('authority', $_POST['authority'.$_POST['data']]);
    $this->setValues('delflag', $_POST['delflag'.$_POST['data']]);
    try {
      $userData = new \Bbs\Model\User();
      $userData->userUpdate([
        'username' => $_POST['username'.$_POST['data']],
        'email' => $_POST['email'.$_POST['data']],
        'image' => $_POST['image'.$_POST['data']],
        'authority' => $_POST['authority'.$_POST['data']],
        'delflag' => $_POST['delflag'.$_POST['data']],
        'id' => $_POST['data']
      ]);
    } catch (\Bbs\Exception\DuplicateEmail $e) {
      $this->setErrors('email', $e->getMessage());
      return;
    }
  }

  protected function userDelete() {
    $clearUser = new \Bbs\Model\User();
    $clearUser->clear($_POST['data']);
  }
}