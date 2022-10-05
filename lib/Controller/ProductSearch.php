<?php
namespace Shopping\Controller;
class ProductSearch extends \Shopping\Controller {
  public function run() {
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset(($_GET['type']))) {
      $productData = $this->searchProduct();
      return $productData;
    }
  }

  public function searchProduct(){
    try {
      $this->validateSearch();
    } catch (\Shopping\Exception\EmptyPost $e) {
      $this->setErrors('keyword', $e->getMessage());
    } catch (\Shopping\Exception\CharLength $e) {
      $this->setErrors('keyword', $e->getMessage());
    }

    $keyword = $_GET['keyword'];
    $this->setValues('keyword', $keyword);
    if ($this->hasError()) {
      return;
    } else {
      $productModel = new \Shopping\Model\Product();
      $productData = $productModel->searchProduct($keyword);
      // var_dump($productData);
      // exit;
      return $productData;
    }
  }

  private function validateSearch() {
    if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['type'])) {
      if ($_GET['keyword'] === '') {
        throw new \Shopping\Exception\EmptyPost("検索キーワードが入力されていません！");
      }
      if (mb_strlen($_GET['keyword']) > 20) {
        throw new \Shopping\Exception\CharLength("キーワードが長すぎます！");
      }
    }
  }
}