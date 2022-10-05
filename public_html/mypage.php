<?php
require_once(__DIR__ .'/header.php');
$app = new Shopping\Controller\UserUpdate();
$app->run();
?>
<h1 class="page__ttl">マイページ</h1>
<div class="container">
  <form action="" method="post" id="userupdate" class="form mypage-form">
    <div class="form-group">
      <label>メールアドレス</label>
      <input type="text" name="email" value="<?=isset($app->getValues()->email) ? h($app->getValues()->email): ''; ?>" class="form-control">
      <p class="err"><?= h($app->getErrors('email')); ?></p>
    </div>
    <div class="form-group">
      <label>ユーザー名</label>
      <input type="text" name="username" value="<?= isset($app->getValues()->username) ? h($app->getValues()->username): ''; ?>" class="form-control">
      <p class="err"><?= h($app->getErrors('username')); ?></p>
    </div>
    <button class="btn btn-primary" onclick="document.getElementById('userupdate').submit();">更新</button>
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
    <p class="err"></p>
  </form>
  <form class="user-delete" action="user_delete_confirm.php" method="post">
    <input type="submit" class="btn btn-default" value="退会する">
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  </form>
</div><!--container -->
</div> <!-- wrapper -->
<p class="copy"><small>&copy; 2022 code lab.</small></p>
<script src="./js/bbs.js"></script>
</body>
</html>
