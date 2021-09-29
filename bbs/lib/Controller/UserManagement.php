<?php
namespace Bbs\Controller;
class UserManagement extends \Bbs\Controller {
  public function run() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->managementUser();
    }
  }

  public function getUsersAll() {
    $userAll = new \Bbs\Model\User();
    $users = $userAll->getUsersAll();
    return $users;
    // var_dump($users);
    // exit();
    // $this->setValues('id', $users->id);
    // $this->setValues('username', $users->username);
    // $this->setValues('email', $users->email);
    // $this->setValues('image', $users->image);
    // $this->setValues('authority', $users->authority);
    // $this->setValues('delflag', $users->delflag);
  }

  protected function managementUser() {
    try {
      $this->validate();
    } catch (\Bbs\Exception\InvalidName $e) {
      $this->setErrors('username', $e->getMessage());
    } catch (\Bbs\Exception\InvalidEmail $e) {
      $this->setErrors('email', $e->getMessage());
    } catch (\Bbs\Exception\InvalidNumber $e) {
      $this->setErrors('authority', $e->getMessage());
    } catch (\Bbs\Exception\InvalidNumber $e) {
      $this->setErrors('delflag', $e->getMessage());
    }
    $this->setValues('username', $_POST['username']);
    $this->setValues('email', $_POST['email']);
    $this->setValues('authority', $_POST['authority']);
    $this->setValues('delflag', $_POST['delflag']);
    if ($this->hasError()) {
      return;
    } else {
      try {
        $userData = new \Bbs\Model\User();
        $userData->userUpdate([
          'username' => $_POST['username'],
          'email' => $_POST['email'],
          'image' => $_POST['image'],
          'authority' => $_POST['authority'],
          'delflag' => $_POST['delflag']
        ]);
      } catch (\Bbs\Exception\DuplicateEmail $e) {
        $this->setErrors('email', $e->getMessage());
        return;
      }
    }
  }
  // $_SESSION['me']->username = $_POST['username'];
  // header('Location: '.SITE_URL . '/admin-users.php');
  // exit();

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
    if ($_POST['authority'] !== 1 || 99) {
      throw new \Bbs\Exception\InvalidNumber("正しい値を入力してください!");
    }
    if ($_POST['delflag'] !== 0 || 1) {
      throw new \Bbs\Exception\InvalidNumber("正しい値を入力してください!");
    }
  }
}



// object(Bbs\Controller\UserManagement)#3 (2) {
//   ["errors":"Bbs\Controller":private]=> object(stdClass)#4 (0) {
//   }
//   ["values":"Bbs\Controller":private]=> object(stdClass)#5 (6) {
//     ["id"]=> string(2) "17"
//     ["username"]=> string(9) "管理者"
//     ["email"]=> string(14) "admin@test.com"
//     ["image"]=> NULL
//     ["authority"]=> string(2) "99"
//     ["delflag"]=> string(1) "0"
//   }
// }

// array(3)
// { [0]=> object(stdClass)#9 (6) {
//    ["id"]=> string(1) "2"
//    ["username"]=> string(12) "ああああ"
//    ["email"]=> string(25) "j27e4dd7c5577v3@gmail.com"
//    ["image"]=> string(21) "img_60cf55ded68b7.png"
//    ["authority"]=> string(1) "1"
//    ["delflag"]=> string(1) "0"
//   } [1]=> object(stdClass)#10 (6) {
//     ["id"]=> string(2) "13"
//     ["username"]=> string(12) "いいいい"
//     ["email"]=> string(27) "j27e4dd7c5577v3@ezweb.ne.jp"
//     ["image"]=> string(21) "img_60c9bd7e9907e.jpg"
//     ["authority"]=> string(1) "1"
//     ["delflag"]=> string(1) "1"
//   } [2]=> object(stdClass)#11 (6) {
//     ["id"]=> string(2) "17"
//     ["username"]=> string(9) "管理者"
//     ["email"]=> string(14) "admin@test.com"
//     ["image"]=> NULL
//     ["authority"]=> string(2) "99"
//     ["delflag"]=> string(1) "0"
//   }
// }