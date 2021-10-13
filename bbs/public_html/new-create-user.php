<?php
require_once(__DIR__ .'/header.php');
$app = new Bbs\Controller\CreateUser();
$app->run();
?>
<h1 class="page__ttl">ユーザー新規登録画面</h1>
<p>権限：「1」＝一般ユーザー　「99」＝管理者</p>
<form action="" method="post" id="usercreate" class="form-group">
  <table class="table" border = "1">
    <tr>
      <td>ユーザー名</td>
      <td>パスワード</td>
      <td>メールアドレス</td>
      <td>ユーザー画像</td>
      <td>権限</td>
      <td>削除フラグ</td>
    </tr>
    <tr>
      <td><input type="text" name="username" size="15px"></td>
      <td><input type="text" name="password" size="15px"></td>
      <td><input type="text" name="email" size="15px"></td>
      <td><input type="text" name="image" size="15px"></td>
      <td><input type="text" name="authority" size="15px" value="1"></td>
      <td><input type="text" name="delflag" size="15px" value="0"></td>
    </tr>
  </table>
  <p class="err"><?= h($app->getErrors('username')); ?></p>
  <p class="err"><?= h($app->getErrors('password')); ?></p>
  <p class="err"><?= h($app->getErrors('email')); ?></p>
  <p class="err"><?= h($app->getErrors('authority')); ?></p>
  <p class="err"><?= h($app->getErrors('delflag')); ?></p>
  <div class="form-group">
    <button class="btn btn-primary" name="update" onclick="document.getElementById('usercreate').submit();">登録</button>
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  </div>
  <a  href="javascript:history.back();">戻る</a>
</form>
<?php
require_once(__DIR__ . '/footer.php');
?>