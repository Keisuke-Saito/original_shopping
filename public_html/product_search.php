<?php
require_once(__DIR__ .'/header.php');
$productCon = new Shopping\Controller\ProductSearch();
$productMod = new Shopping\Model\Product();
$products = $productCon->run();
?>
<h1 class="page__ttl">商品検索</h1>
<div class="home-btn">
  <a class="btn btn-info" href="<?= SITE_URL; ?>/cart_list.php">カートへ</a>
</div>
<form action="" method="get" class="form-group form-search">
    <div class="form-group">
      <input type="text" name="keyword" value="<?= isset($productCon->getValues()->keyword) ? h($productCon->getValues()->keyword): ''; ?>" placeholder="商品を検索">
      <p class="err"><?= h($productCon->getErrors('keyword')); ?></p>
    </div>
    <div class="form-group">
      <input type="submit" value="検索" class="btn btn-success">
      <input type="hidden" name="type" value="searchproduct">
    </div>
</form>
<?php $products != '' ? $con = count($products) : $con = 0; ?>
<?php if (($productCon->getErrors('keyword'))): ?>
<?php else : ?>
<div>キーワード：<?= $_GET['keyword']; ?>  該当件数：<?= $con; ?>件</div>
<?php endif; ?>
<form action="" method="post" id="cartin" class="form-group">
  <div class="product-group">
  <?php if ($con > 0): ?>
    <?php foreach($products as $product): ?>
    <div class="product-content" data-productid="<?= $product->p_id; ?>">
      <div class="imgfile">
        <img src="<?= !empty($product->product_image) ? './gazou/'. h($product->product_image) : './asset/img/no_image.jpg'; ?>" alt="">
      </div>
      <ul class="product__head">
        <li class="product__ttl"><?= h($product->product_name); ?>
          <div class="product__price">￥<?= h(number_format($product->price)); ?></div>
        </li>
        <li class="product__count__menu<?= h($product->p_id); ?>">
          <div class="product__count">
            <span>数量</span>
            <select class="quantity">
              <option value="1" data-quantity="1">1</option>
              <option value="2" data-quantity="2">2</option>
              <option value="3" data-quantity="3">3</option>
              <option value="4" data-quantity="4">4</option>
              <option value="5" data-quantity="5">5</option>
              <option value="6" data-quantity="6">6</option>
              <option value="7" data-quantity="7">7</option>
              <option value="8" data-quantity="8">8</option>
              <option value="9" data-quantity="9">9</option>
              <option value="10" data-quantity="10">10</option>
            </select>
          </div>
          <div class="cart__item">
            <span class="cart__text<?php if(isset($product->c_id)) {echo ' cart__in';} ?>"></span>
            <span class="cart__btn<?php if(isset($product->c_id)) {echo ' active';} ?>"><i class="fas fa-cart-arrow-down fa-2x"></i></span>
          </div>
        </li>
      </ul>
      <p class="content-item"><?= h($product->content); ?></p>
    </div>
    <?php endforeach; ?>
  <?php else: ?>
    <p>キーワードに該当する商品が見つかりませんでした。</p>
  <?php endif; ?>
  </div>
</form>
<?php
require_once(__DIR__ . '/footer.php');
?>