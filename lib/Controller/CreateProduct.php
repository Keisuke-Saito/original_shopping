<?php
namespace Shopping\Controller;
class CreateProduct extends \Shopping\Controller {
  public function run() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // var_dump($_FILES['product_image']);
      // exit;
      if (isset($_POST['img_delete'])) {
        $this->imageDelete();
      }
      $this->newCreateProduct();
    }
  }

  protected function newCreateProduct() {
    try {
      $this->validate();
    } catch (\Shopping\Exception\InvalidProductName $e) {
      $this->setErrors('product_name', $e->getMessage());
    } catch (\Shopping\Exception\InvalidPrice $e) {
      $this->setErrors('price', $e->getMessage());
    }
    $this->setValues('product_name', $_POST['product_name']);
    $this->setValues('price', $_POST['price']);
    $this->setValues('content', $_POST['content']);
    if ($this->hasError()) {
      return;
    } else {
      $product_img = $_FILES['product_image'];
      $ext = substr($product_img['name'], strrpos($product_img['name'], '.') + 1);
      $product_img['name'] = uniqid("img_") .'.'. $ext;
      $newProduct = new \Shopping\Model\Product();
      if ($product_img['size'] > 0) {
        move_uploaded_file($product_img['tmp_name'],'./gazou/'.$product_img['name']);
        $newProduct->createProduct([
          'product_name' => $_POST['product_name'],
          'price' => $_POST['price'],
          'product_image' => $product_img['name'],
          'content' => $_POST['content']
        ]);
      } else {
        $newProduct->createProduct([
          'product_name' => $_POST['product_name'],
          'price'=> $_POST['price'],
          'product_image' => '',
          'content' => $_POST['content']
        ]);
      }
    }
    header('Location: '. SITE_URL . '/admin_products.php');
    exit();
  }

  // 初期画像に戻す
  public function imageDelete() {
    $_FILES['product_image'] = '';
    header('Location: '. SITE_URL . '/new_create_product.php');
    exit();
  }

  private function validate() {
    if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
      echo "不正なトークンです!";
      exit();
    }
    if ($_POST['product_name'] === '') {
      throw new \Shopping\Exception\InvalidProductName("商品名が入力されていません！");
    }
    if ($_POST['price'] === '') {
      throw new \Shopping\Exception\InvalidPrice("商品価格を入力して下さい！");
    }
    if ($_POST['price'] < 1 || !(preg_match('/^[0-9]+$/', $_POST['price']))) {
      throw new \Shopping\Exception\InvalidPrice("商品価格は1円以上の整数で入力して下さい！");
    }
  }
}


