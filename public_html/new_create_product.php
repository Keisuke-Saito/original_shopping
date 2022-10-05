<?php
require_once(__DIR__ .'/header.php');
$app = new Shopping\Controller\CreateProduct();
$app->run();
?>
<h1 class="page__ttl">商品新規登録</h1>
<p>商品画像を挿入し、商品名、価格、商品説明を入力して下さい。<br>※部分は必ず入力が必要です。</p>
<form action="" method="post" id="productcreate" class="form-group" enctype="multipart/form-data">
  <table class="table" border = "1">
    <tr>
      <td>商品画像</td>
      <td>※商品名</td>
      <td>※価格</td>
      <td>商品説明</td>
    </tr>
    <tr>
      <td>
        <div class="form-group">
          <div class="imgarea <?= isset($app->getValues()->image) ? '': 'noimage' ?>">
            <label>
              <span class="file-btn">挿入
                <input type="file" name="product_image" class="form" style="display:none" accept="image/*">
              </span>
            </label>
            <div class="imgfile">
              <img src="<?= !empty($app->getValues()->image) ? './gazou/'. h($app->getValues()->image) : './asset/img/no_image.jpg'; ?>" alt="">
            </div>
            <div class="form-group">
              <button name="img_delete" onclick="document.getElementById('productupdate').submit();">削除</button>
              <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
            </div>
          </div>
        </div>
      </td>
      <td><input type="text" name="product_name" value="<?= isset($app->getValues()->product_name) ? h($app->getValues()->product_name): ''; ?>"></td>
      <td><input type="text" name="price" value="<?= isset($app->getValues()->price) ? h($app->getValues()->price): ''; ?>"></td>
      <td><textarea name="content" value="<?= isset($app->getValues()->content) ? h($app->getValues()->content): ''; ?>"></textarea></td>
    </tr>
  </table>
  <p class="err"><?= h($app->getErrors('product_name')); ?></p>
  <p class="err"><?= h($app->getErrors('price')); ?></p>
  <div class="form-group">
    <button class="btn btn-success" name="update" onclick="document.getElementById('productcreate').submit();">登録</button>
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  </div>
  <a href="javascript:history.back();">戻る</a>
</form>
<?php
require_once(__DIR__ . '/footer.php');
?>