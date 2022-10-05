<?php
namespace Shopping\Model;
class Product extends \Shopping\Model {
  // 商品一覧画面で商品情報取得
  public function getProductsAll() {
    $user_id = $_SESSION['me']->id;
    $stmt = $this->db->query("SELECT p.id AS p_id,product_name,price,product_image,content,c.id AS c_id FROM products AS p LEFT JOIN product_sales AS c ON p.id = c.product_id AND c.user_id = $user_id ORDER BY p.id asc");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  // 商品検索
   public function searchProduct($keyword) {
    $user_id = $_SESSION['me']->id;
    $stmt = $this->db->prepare("SELECT p.id AS p_id,product_name,price,product_image,content,c.id AS c_id FROM products AS p LEFT JOIN product_sales AS c ON p.id = c.product_id AND c.user_id = $user_id WHERE product_name LIKE :product_name ORDER BY p.id asc");
    $stmt->execute([':product_name' => '%'.$keyword.'%']);
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  // カート内商品の取得
  public function getProductCartinAll() {
    $user_id = $_SESSION['me']->id;
    $stmt = $this->db->query("SELECT p.id AS p_id,product_name,price,quantity,product_image,content,c.id AS c_id FROM products AS p INNER JOIN product_sales AS c ON p.id = c.product_id AND c.user_id = $user_id ORDER BY p.id asc");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  // カート追加機能（ajax）
  public function changeCartin($values) {
    // var_dumo($values);
    // exit;
    try {
      $this->db->beginTransaction();
      $stmt = $this->db->prepare("SELECT * FROM product_sales WHERE product_id = :product_id AND user_id = :user_id");
      $stmt->execute([
        ':product_id' => $values['product_id'],
        ':user_id' => $values['user_id']
      ]);
      $stmt->setFetchMode(\PDO::FETCH_CLASS, 'stdClass');
      $rec = $stmt->fetch();
      $cart_flag = 0;
      if (empty($rec)) {
        $sql = "INSERT INTO product_sales (product_id,quantity,user_id,created) VALUES (:product_id,:quantity,:user_id,now())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
          ':product_id' => $values['product_id'],
          ':quantity' => $values['quantity'],
          ':user_id' => $values['user_id']
        ]);
        $cart_flag = 1;
      } else {
        $sql = "DELETE FROM product_sales WHERE product_id = :product_id AND user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $res = $stmt->execute([
          ':product_id' => $values['product_id'],
          ':user_id' => $values['user_id']
        ]);
        $cart_flag = 0;
      }
      $this->db->commit();
      return $cart_flag;
    } catch (\Exception $e) {
      echo $e->getMessage();
      $this->db->rollBack();
    }
  }

  // カート内商品から削除
  public function cartout($id) {
    $stmt = $this->db->prepare("DELETE FROM product_sales WHERE product_id = :id");
    $stmt->execute([
      ':id' => $id
    ]);
  }

  // 商品新規作成
  public function createProduct($values) {
    $stmt = $this->db->prepare("INSERT INTO products (product_name,price,product_image,content,created,modified) VALUES (:product_name,:price,:product_image,:content,now(),now())");
    $res = $stmt->execute([
      ':product_name' => $values['product_name'],
      ':price' => $values['price'],
      ':product_image' => $values['product_image'],
      ':content' => $values['content'],
    ]);
  }

  // 管理画面で商品情報取得
  public function getProducts() {
    $stmt = $this->db->query("SELECT id,product_name,price,product_image,content FROM products ORDER BY id ASC");
    return $stmt->fetchAll(\PDO::FETCH_OBJ);
  }

  // 管理画面で更新する
  public function productUpdate($values) {
    $stmt = $this->db->prepare("UPDATE products SET product_name = :product_name, price = :price, content = :content WHERE id = :id");
    $res = $stmt->execute([
      ':product_name' => $values['product_name'],
      ':price' => $values['price'],
      ':content' => $values['content'],
      ':id' => $values['id']
    ]);
  }

  // 管理画面で削除する
  public function deleteproduct($id) {
    $stmt = $this->db->prepare("DELETE FROM products WHERE id = :id");
    $stmt->execute([
      ':id' => $id
    ]);
  }
}