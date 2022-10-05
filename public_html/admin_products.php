<?php
require_once(__DIR__ .'/header.php');
$app = new Shopping\Controller\ProductManagement();
$app->run();
$products = $app->getProductsAll();
?>
<h1 class="page__ttl">商品情報管理</h1>
<div class="admin-btn">
  <a class="btn btn-success" href="<?= SITE_URL; ?>/new_create_product.php">商品新規登録</a>
</div>
<p>現在登録されている商品のリストです。<br>編集したい商品にチェックを入れ、更新内容を入力して下さい。</p>
<p class="err"><?= h($app->getErrors('data')); ?></p>
<p class="err"><?= h($app->getErrors('product_name')); ?></p>
<p class="err"><?= h($app->getErrors('price')); ?></p>
<form action="" method="post" id="productedit" class="form-group">
  <table class="table" border = "1">
    <tr>
      <td></td>
      <td>id</td>
      <td>商品画像</td>
      <td>商品名</td>
      <td>価格</td>
      <td>商品説明</td>
    </tr>
    <?php foreach($products as $product): ?>
      <tr>
        <td><input type="radio" name="data" value="<?= h($product->id); ?>">
          <td><?= h($product->id); ?></td>
          <td>
            <div class="form-group">
              <div class="imgarea <?= isset($product->product_image) ? '': 'noimage' ?>">
                <div class="imgfile">
                  <img src="<?= !empty($product->product_image) ? './gazou/'. h($product->product_image) : './asset/img/no_image.jpg'; ?>" alt="">
                </div>
              </div>
            </div>
          </td>
          <td>
            <input type="text" name="product_name<?= h($product->id); ?>" value="<?= h($product->product_name) ?>">
          </td>
          <td>
            <input type="text" name="price<?= h($product->id); ?>" value="<?= h($product->price); ?>">
          </td>
          <td>
            <textarea name="content<?= h($product->id); ?>"><?= h($product->content); ?></textarea>
          </td>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
  <div class="form-group">
      <button class="btn btn-success" name="update" onclick="document.getElementById('productedit').submit();">更新</button>
      <button class="btn btn-success" name="delete" onclick="document.getElementById('productedit').submit();">削除</button>
      <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    </div>
</form>
<?php
require_once(__DIR__ . '/footer.php');
?>