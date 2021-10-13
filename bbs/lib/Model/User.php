<?php
namespace Bbs\Model;
class User extends \Bbs\Model {
  public function create($values) {
    $stmt = $this->db->prepare("INSERT INTO users (username,email,password,created,modified) VALUES (:username,:email,:password,now(),now())");
    $res = $stmt->execute([
      ':username' => $values['username'],
      ':email' => $values['email'],
      // パスワードのハッシュ化(暗号化）
      ':password' => password_hash($values['password'],PASSWORD_DEFAULT)
    ]);
    // メールアドレスがユニークでなければfalseを返す
    if ($res === false) {
      throw new \Bbs\Exception\DuplicateEmail();
    }
  }

  public function login($values) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email;");
    $stmt->execute([
      ':email' => $values['email']
    ]);
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();
    if (empty($user)) {
      throw new \Bbs\Exception\UnmatchEmailOrPassword();
    }
    if (!password_verify($values['password'], $user->password)) {
      throw new \Bbs\Exception\UnmatchEmailOrPassword();
    }
    if ($user->delflag == 1) {
      throw new \Bbs\Exception\DeleteUser();
    }
    return $user;
  }

  // 自分のメモ
// prepareメソッドはPDOでSQLを実行する際に使用（queryメソッドも）
// prepareメソッドはユーザーからの入力をSQLに含めることが出来る。つまり変数を埋め込みできる（queryメソッドは出来ない）
// executeメソッドで用意したSQL文の変数部分に実際の値をセットする（今回は「username」と「email」）
// この実行するSQLを準備し、後からSQLを実行することを「プリペアードステートメント」という。
// データベースを不正に操作するのを防ぐ目的がある。

// パスワードのハッシュ化（暗号化）にはPHPのpassword_hash関数を使うと簡単に暗号化できる。

  public function find($id) {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindValue('id',$id);
    $stmt->execute();
    $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
    $user = $stmt->fetch();
    return $user;
  }

  public function update($values) {
    $stmt = $this->db->prepare("UPDATE users SET username = :username,email = :email, image = :image, modified = now() where id = :id");
    $res = $stmt->execute([
      ':username' => $values['username'],
      ':email' => $values['email'],
      ':image' => $values['userimg'],
      ':id' => $_SESSION['me']->id,
    ]);
    if ($res === false) {
      throw new \Bbs\Exception\DuplicateEmail();
    }
  }


  public function delete() {
    $stmt = $this->db->prepare("UPDATE users SET delflag = :delflag, modified = now() where id = :id");
    $stmt->execute([
      ':delflag' => 1,
      ':id' => $_SESSION['me']->id,
    ]);
  }

  // マイページでのユーザー画像削除
  public function clearImg($values) {
    $stmt = $this->db->prepare("UPDATE users SET image = :image, modified = now() where id = :id");
    $stmt->execute([
      ':image' => $values['noimage'],
      ':id' => $values['id'],
    ]);
  }

  // 全ユーザー情報取得
  public function getUsersAll() {
    $stmt = $this->db->query("SELECT id,username,email,image,authority,delflag FROM users ORDER BY id ASC");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  // 管理者画面でのユーザー情報更新
  public function userUpdate($values) {
    $stmt = $this->db->prepare("UPDATE users SET username = :username, email = :email, image = :image, authority = :authority, delflag = :delflag where id = :id");
    $res = $stmt->execute([
      ':username' => $values['username'],
      ':email' => $values['email'],
      ':image' => $values['image'],
      ':authority' => $values['authority'],
      ':delflag' => $values['delflag'],
      ':id' => $values['id'],
    ]);
    if ($res === false) {
      throw new \Bbs\Exception\DuplicateEmail();
    }
  }

  // 管理者画面でのユーザー削除
  public function clear($id) {
    $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute([
      ':id' => $id
    ]);
  }

  // 管理者画面でのユーザー新規登録
  public function createUser($values) {
    // var_dump($values);
    // exit();
    $stmt = $this->db->prepare("INSERT INTO users (username,password,email,image,authority,delflag,created,modified) VALUES (:username,:password,:email,:image,:authority,:delflag,now(),now())");
    $res = $stmt->execute([
      ':username' => $values['username'],
      ':password' => password_hash($values['password'],PASSWORD_DEFAULT),
      ':email' => $values['email'],
      ':image' => $values['image'],
      ':authority' => $values['authority'],
      ':delflag' => $values['delflag']
    ]);
    if ($res === false) {
      throw new \Bbs\Exception\DuplicateEmail();
    }
  }
}