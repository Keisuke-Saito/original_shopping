<?php
namespace Shopping\Model;
class User extends \Shopping\Model {
  // ユーザー登録
  public function create($values) {
    $stmt = $this->db->prepare("INSERT INTO users (username,email,password,created,modified) VALUES (:username,:email,:password,now(),now())");
    $res = $stmt->execute([
      ':username' => $values['username'],
      ':email' => $values['email'],
      ':password' => password_hash($values['password'],PASSWORD_DEFAULT)
    ]);
    if ($res === false) {
      throw new \Shopping\Exception\DuplicateEmail();
    }
  }

  // ログイン
  public function login($values) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email;");
    $stmt->execute([
      ':email' => $values['email']
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();
    if (empty($user)) {
      throw new \Shopping\Exception\UnmatchEmailOrPassword();
    }
    if (!password_verify($values['password'], $user->password)) {
      throw new \Shopping\Exception\UnmatchEmailOrPassword();
    }
    if ($user->delflag == 1) {
      throw new \Shopping\Exception\DeleteUser();
    }
    return $user;
  }

  // マイページ画面の表示
  public function find($id) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindValue('id',$id);
    $stmt->execute();
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();
    return $user;
  }

  // マイページ情報更新
  public function update($values) {
    $stmt = $this->db->prepare("UPDATE users SET username = :username,email = :email, modified = now() where id = :id");
    $res = $stmt->execute([
      ':username' => $values['username'],
      ':email' => $values['email'],
      ':id' => $_SESSION['me']->id,
    ]);
    if ($res === false) {
      throw new \Shopping\Exception\DuplicateEmail();
    }
  }

  // ユーザー退会
  public function delete() {
    $stmt = $this->db->prepare("UPDATE users SET delflag = :delflag, modified = now() where id = :id");
    $stmt->execute([
      ':delflag' => 1,
      ':id' => $_SESSION['me']->id,
    ]);
  }

  // 全ユーザー情報取得
  public function getUsersAll() {
    $stmt = $this->db->query("SELECT id,username,email,authority,delflag FROM users ORDER BY id ASC");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  // 管理者画面でのユーザー情報更新
  public function userUpdate($values) {
    $stmt = $this->db->prepare("UPDATE users SET username = :username, email = :email, authority = :authority, delflag = :delflag where id = :id");
    $res = $stmt->execute([
      ':username' => $values['username'],
      ':email' => $values['email'],
      ':authority' => $values['authority'],
      ':delflag' => $values['delflag'],
      ':id' => $values['id']
    ]);
    if ($res === false) {
      throw new \Shopping\Exception\DuplicateEmail();
    }
  }

  // 管理者画面でのユーザー新規登録
  public function createUser($values) {
    $stmt = $this->db->prepare("INSERT INTO users (username,email,password,authority,delflag,created,modified) VALUES (:username,:email,:password,:authority,:delflag,now(),now())");
    $res = $stmt->execute([
      ':username' => $values['username'],
      ':email' => $values['email'],
      ':password' => password_hash($values['password'],PASSWORD_DEFAULT),
      ':authority' => $values['authority'],
      ':delflag' => $values['delflag']
    ]);
    if ($res === false) {
      throw new \Shopping\Exception\DuplicateEmail();
    }
  }

  // 管理者画面でのユーザー削除
  public function deleteuser($id) {
    $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute([
      ':id' => $id
    ]);
  }
}