<?php
require_once(__DIR__ .'/header.php');
$productMod = new Shopping\Model\Product();
$products = $productMod->getProductCartinAll();
$total = 0;
foreach($products as $product) {
  $total += $product->price * $product->quantity;
}
?>
<h1 class="page__ttl">購入内容確認</h1>
<p>以下の商品を購入します。よろしければ購入ボタンを押して下さい。</p>
<a class="backcart" href="javascript:history.back();">カートへ戻る</a>
<div class="product-group-check">
  <?php foreach($products as $product): ?>
  <div class="product-content-check">
    <div class="imgfile-check">
      <img src="<?= !empty($product->product_image) ? './gazou/'. h($product->product_image) : './asset/img/no_image.jpg'; ?>" alt="">
    </div>
    <div class="product__head__check">
      <div class="product__ttl__check"><?= h($product->product_name); ?></div>
      <div class="product__price__check">￥<?= h(number_format($product->price)); ?></div>
      <div class="now__count__check">数量：<?= h($product->quantity); ?></div>
    </div>
    <div class="subtotal__price">
      <div class="subtotal__text">
        小計：￥<?= h(number_format($product->price * $product->quantity)); ?>
      </div>
    </div>
  </div>
  <?php endforeach; ?>
  <div class="total__price">
    <div class="total__text">
      合計：￥<?= h(number_format($total)); ?>
    </div>
  </div>
  <div class="form-group purchase-btn">
    <a class="btn btn-info" href="<?= SITE_URL; ?>/purchase_done.php">購入</a>
  </div>
</div>
<?php
require_once(__DIR__ . '/footer.php');
?>

