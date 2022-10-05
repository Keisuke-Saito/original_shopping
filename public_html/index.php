<?php
require_once(__DIR__ .'/header.php');
?>
<?php if(isset($_SESSION['me'])) { ?>
  <h1 class="page__ttl">いらっしゃいませ！</h1>
  <div class="home-img">
    <img src="./asset/img/shopping_ichiba_yatai.png";>
  </div>
  <div class="home-btn">
    <a class="btn btn-success" href="<?= SITE_URL; ?>/product_list.php">お買い物を始める</a>
    <a class="btn btn-success" href="<?= SITE_URL; ?>/mypage.php">マイページへ</a>
  </div>
<?php } else { ?>
  <h1 class="page__ttl">ショッピングサイトへようこそ！</h1>
  <div class="home-img">
    <img src="./asset/img/shopping_syoutengai.png";>
  </div>
  <div class="home-btn">
    <a class="btn btn-success" href="<?= SITE_URL; ?>/login.php">ログイン</a>
    <a class="btn btn-success" href="<?= SITE_URL; ?>/signup.php">ユーザー登録</a>
  </div>
<?php } ?>
<?php
require_once(__DIR__ .'/footer.php');
?>