<?php
namespace Shopping\Controller;
class Login extends \Shopping\Controller {
  public function run() {
    if ($this->isLoggedIn()) {
      header('Location: ' . SITE_URL);
      exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $this->postProcess();
    }
  }
  protected function postProcess() {
    try {
      $this->validate();
    } catch (\Shopping\Exception\EmptyPost $e) {
      $this->setErrors('login', $e->getMessage());
    }
    $this ->setValues('email', $_POST['email']);
    if ($this->hasError()) {
      return;
    } else {
      try {
        $userModel = new \Shopping\Model\User();
        $user = $userModel->login([
          'email' => $_POST['email'],
          'password' => $_POST['password']
        ]);
      }
      catch (\Shopping\Exception\UnmatchEmailOrPassword $e) {
        $this->setErrors('login', $e->getMessage());
        return;
      }
      catch (\Shopping\Exception\DeleteUser $e) {
        $this->setErrors('login', $e->getMessage());
        return;
      }
      session_regenerate_id(true);
      $_SESSION['me'] = $user;
      header('Location: '. SITE_URL);
      exit();
    }
  }
  private function validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "トークンが不正です!";
      exit();
    }
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
      echo "不正なフォームから登録されています!";
      exit();
    }
    if ($_POST['email'] === '' || $_POST['password'] === '') {
      throw new \Shopping\Exception\EmptyPost("メールアドレスとパスワードを入力してください!");
    }
  }
}