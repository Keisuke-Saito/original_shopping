<?php
require_once(__DIR__ .'/header.php');
$app = new Shopping\Controller\UserManagement();
$app->run();
$users = $app->getUsersAll();
?>
<h1 class="page__ttl">ユーザー情報管理</h1>
<div class="admin-btn">
  <a class="btn btn-success" href="<?= SITE_URL; ?>/new_create_user.php">ユーザー新規登録</a>
</div>
<p>現在登録されているユーザーのリストです。<br>編集したいユーザーにチェックを入れ、更新内容を入力して下さい。<br>※権限："1"＝一般ユーザー、"99"＝管理者<br>※削除フラグ："0"＝OFF、"1"＝ON（"1"の場合、削除済みユーザーとなります。）</p>
<p class="err"><?= h($app->getErrors('data')); ?></p>
<p class="err"><?= h($app->getErrors('username')); ?></p>
<p class="err"><?= h($app->getErrors('email')); ?></p>
<p class="err"><?= h($app->getErrors('authority')); ?></p>
<p class="err"><?= h($app->getErrors('delflag')); ?></p>
<form action="" method="post" id="useredit" class="form-group">
  <table class="table" border = "1">
    <tr>
      <td></td>
      <td>id</td>
      <td>ユーザー名</td>
      <td>メールアドレス</td>
      <td>権限</td>
      <td>削除フラグ</td>
    </tr>
    <?php foreach($users as $user): ?>
      <tr>
        <td><input type="radio" name="data" value="<?= h($user->id); ?>">
          <td><?= h($user->id); ?></td>
          <td>
            <input type="text" name="username<?= h($user->id); ?>" value="<?= h($user->username); ?>">
          </td>
          <td>
            <input type="text" name="email<?= h($user->id); ?>" value="<?= h($user->email); ?>">
          </td>
          <td>
            <input type="text" name="authority<?= h($user->id); ?>" value="<?= h($user->authority); ?>">
          </td>
          <td>
            <input type="text" name="delflag<?= h($user->id); ?>" value="<?= h($user->delflag); ?>">
          </td>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
  <div class="form-group">
    <button class="btn btn-success" name="update" onclick="document.getElementById('useredit').submit();">更新</button>
    <button class="btn btn-success" name="delete" onclick="document.getElementById('useredit').submit();">削除</button>
    <input type="hidden" name="token" value="<?= h($_SESSION['token']); ?>">
  </div>
</form>
<?php
require_once(__DIR__ . '/footer.php');
?>