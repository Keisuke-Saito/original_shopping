<?php
namespace Shopping\Controller;
class ProductList extends \Shopping\Controller {
  public function run() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // var_dump($_POST);
      // exit;
    }
  }

  public function getProductsAll() {
    $productAll = new \Shopping\Model\Product();
    $products = $productAll->getProductsAll();
    return $products;
  }
}