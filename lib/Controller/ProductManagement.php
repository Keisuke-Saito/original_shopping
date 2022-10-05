<?php
namespace Shopping\Controller;
class ProductManagement extends \Shopping\Controller {
  public function run() {
    if ($_SESSION['me']->authority == 1) {
      header('Location:' . SITE_URL . '/product_list.php');
      exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      try {
        if (empty($_POST['data'])) {
          throw new \Shopping\Exception\EmptyPost("商品を選択してください！");
        }
      } catch (\Shopping\Exception\EmptyPost $e) {
        $this->setErrors('data', $e->getMessage());
      }
      if ($this->hasError()) {
        return;
      }
      if (isset($_POST['delete'])) {
        var_dump($_POST);
        exit;
        $this->productDelete();
      } else {
        $this->productManagement();
      }
    }
  }

  // 全商品情報取得
  public function getProductsAll() {
    $productAll = new \Shopping\Model\Product();
    $products = $productAll->getProducts();
    return $products;
  }

  // 商品情報更新
  protected function productManagement() {
    try {
      $this->validate();
    } catch (\Shopping\Exception\InvalidProductName $e) {
      $this->setErrors('product_name', $e->getMessage());
    } catch (\Shopping\Exception\InvalidPrice $e) {
      $this->setErrors('price', $e->getMessage());
    }
    if ($this->hasError()) {
      return;
    }
    $this->setValues('product_name', $_POST['product_name'.$_POST['data']]);
    $this->setValues('price', $_POST['price'.$_POST['data']]);
    $this->setValues('content', $_POST['content'.$_POST['data']]);
    $productData = new \Shopping\Model\Product();
    $productData->productUpdate([
      'product_name' => $_POST['product_name'.$_POST['data']],
      'price' => $_POST['price'.$_POST['data']],
      'content' => $_POST['content'.$_POST['data']],
      'id' => $_POST['data']
    ]);
    return;
  }

  // 商品削除
  protected function productDelete() {
    $deleteProduct = new \Shopping\Model\Product();
    $deleteProduct->deleteproduct($_POST['data']);
  }

  // バリデーション
  private function validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "不正なトークンです!";
      exit();
    }
    if ($_POST['product_name'.$_POST['data']] === '') {
      throw new \Shopping\Exception\InvalidProductName("商品名が入力されていません！");
    }
    if ($_POST['price'.$_POST['data']] === '') {
      throw new \Shopping\Exception\InvalidPrice("商品価格を入力して下さい！");
    }
    if ($_POST['price'.$_POST['data']] < 1 || !(preg_match('/^[0-9]+$/', $_POST['price'.$_POST['data']]))) {
      throw new \Shopping\Exception\InvalidPrice("商品価格は1円以上の整数で入力して下さい！");
    }
  }
}