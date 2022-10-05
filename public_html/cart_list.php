<?php
require_once(__DIR__ .'/header.php');
$productMod = new Shopping\Model\Product();
$products = $productMod->getProductCartinAll();
?>
<h1 class="page__ttl">カート内商品</h1>
<div class="home-btn">
  <a class="btn btn-success" href="<?= SITE_URL; ?>/product_list.php">商品一覧へ</a>
  <a class="btn btn-info" href="<?= SITE_URL; ?>/purchase_confirm.php">レジへ進む</a>
</div>
<div class="product-group">
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
          <span class="change__count">数量：</span>
          <select class="quantity">
            <option value="1" data-quantity="1" <?= $product->quantity == 1 ? 'selected' : ''; ?>>1</option>
            <option value="2" data-quantity="2" <?= $product->quantity == 2 ? 'selected' : ''; ?>>2</option>
            <option value="3" data-quantity="3" <?= $product->quantity == 3 ? 'selected' : ''; ?>>3</option>
            <option value="4" data-quantity="4" <?= $product->quantity == 4 ? 'selected' : ''; ?>>4</option>
            <option value="5" data-quantity="5" <?= $product->quantity == 5 ? 'selected' : ''; ?>>5</option>
            <option value="6" data-quantity="6" <?= $product->quantity == 6 ? 'selected' : ''; ?>>6</option>
            <option value="7" data-quantity="7" <?= $product->quantity == 7 ? 'selected' : ''; ?>>7</option>
            <option value="8" data-quantity="8" <?= $product->quantity == 8 ? 'selected' : ''; ?>>8</option>
            <option value="9" data-quantity="9" <?= $product->quantity == 9 ? 'selected' : ''; ?>>9</option>
            <option value="10" data-quantity="10" <?= $product->quantity == 10 ? 'selected' : ''; ?>>10</option>
          </select>
        </div>
        <div class="cart__item">
          <span class="cart__text<?php if(isset($product->c_id)) {echo ' cart__in';} ?>"></span>
          <span class="cart__btn<?php if(isset($product->c_id)) {echo ' active';} ?>"><i class="fas fa-cart-arrow-down fa-2x"></i></span>
        </div>
      </li>
    </ul>
  </div>
  <?php endforeach; ?>
</div>
<?php
require_once(__DIR__ . '/footer.php');
?>