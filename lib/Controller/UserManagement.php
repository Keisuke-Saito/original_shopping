<?php
namespace Shopping\Controller;
class UserManagement extends \Shopping\Controller {
  public function run() {
    if ($this->isLoggedIn()) {
      if ($_SESSION['me']->authority == 1) {
        header('Location:' . SITE_URL .'/product_list.php');
        exit();
      }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      try {
        if (empty($_POST['data'])) {
          throw new \Shopping\Exception\EmptyPost("ユーザーを選択してください！");
        }
      } catch (\Shopping\Exception\EmptyPost $e) {
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

  // 全ユーザー情報取得
  public function getUsersAll() {
    $userAll = new \Shopping\Model\User();
    $users = $userAll->getUsersAll();
    return $users;
  }

  // ユーザー情報更新
  protected function managementUser() {
    try {
      $this->validate();
    } catch (\Shopping\Exception\InvalidName $e) {
      $this->setErrors('username', $e->getMessage());
    } catch (\Shopping\Exception\InvalidEmail $e) {
      $this->setErrors('email', $e->getMessage());
    } catch (\Shopping\Exception\InvalidNumber $e) {
      $this->setErrors('authority', $e->getMessage());
    } catch (\Shopping\Exception\InvalidNumber $e) {
      $this->setErrors('delflag', $e->getMessage());
    }
    if ($this->hasError()){
      return;
    }
    $this->setValues('username', $_POST['username'.$_POST['data']]);
    $this->setValues('email', $_POST['email'.$_POST['data']]);
    $this->setValues('authority', $_POST['authority'.$_POST['data']]);
    $this->setValues('delflag', $_POST['delflag'.$_POST['data']]);
    try {
      $userData = new \Shopping\Model\User();
      $userData->userUpdate([
        'username' => $_POST['username'.$_POST['data']],
        'email' => $_POST['email'.$_POST['data']],
        'authority' => $_POST['authority'.$_POST['data']],
        'delflag' => $_POST['delflag'.$_POST['data']],
        'id' => $_POST['data']
      ]);
    } catch (\Shopping\Exception\DuplicateEmail $e) {
      $this->setErrors('email', $e->getMessage());
      return;
    }
  }

  // ユーザー削除
  protected function userDelete() {
    $deleteUser = new \Shopping\Model\User();
    $deleteUser->deleteuser($_POST['data']);
  }

  // バリデーション
  private function validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "不正なトークンです!";
      exit();
    }
    if ($_POST['username'.$_POST['data']] === '') {
      throw new \Shopping\Exception\InvalidName("ユーザー名が入力されていません!");
    }
    if (!filter_var($_POST['email'.$_POST['data']],FILTER_VALIDATE_EMAIL)) {
      throw new \Shopping\Exception\InvalidEmail("メールアドレスが不正です!");
    }
    if ($_POST['authority'.$_POST['data']] != 1 && $_POST['authority'.$_POST['data']] != 99) {
      throw new \Shopping\Exception\InvalidNumber("”権限”には「1」か「99」を入力してください!");
    }
    if ($_POST['delflag'.$_POST['data']] != 0 && $_POST['delflag'.$_POST['data']] != 1) {
      throw new \Shopping\Exception\InvalidNumber("”削除フラグ”には「0」か「1」を入力してください!");
    }
  }
}