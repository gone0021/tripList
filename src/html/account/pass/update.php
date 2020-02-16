<?php
  // クラスの読み込み
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/OurCalendar/html";
  require_once($root."/classes/util/SessionUtil.php");
  
  SessionUtil::sessionStart();

  $token = bin2hex(openssl_random_pseudo_bytes(108));
  $_SESSION['token'] = $token;

?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>パスワードの再設定</title>
  <link rel="stylesheet" href="../../css/normalize.css">
  <link rel="stylesheet" href="../../css/bootstrap.css">
  <link rel="stylesheet" href="../../css/main.css">
</head>

<body>
<div class="container">
  <!-- body-header -->
  <header>
    <h1 id="head-l">パスワードの再設定</h1>
    <br>
    <div class="align-r-m3"><a href="../../">ログイン画面へ</a></div>
  </header>

  <!-- body-main -->
  <main>
    <!-- 送信フォーム -->
    <form action="./update_action.php" method="post">
      <!-- トークンの送信 -->
      <input type="hidden" name="token" value="<?= $token ?>">

      <div class="form-group col-6 mx-auto">
        <h4 class="mt-3">
          メールアドレス：
          <!-- メールアドレス -->
          <?=$_SESSION["email2"]?>
          <input type="hidden" name="email" value="<?=$_SESSION["email2"]?>">
        </h4>
        <!-- 入力フォーム -->
        <input type="hidden" name="email" value="<?=$_SESSION["email2"]?>" id="email" class="form-control">
      </div>

      <!-- ※パスワード -->
      <div class="form-group col-6 mx-auto">
        <!-- バリデーション -->
        <?php if (isset($_SESSION['msg']['pass1'])) : ?>
          <p class="error"><?= $_SESSION['msg']['pass1'] ?></p>
        <?php endif ?>
        <label for="pass1">パスワード（半角英数字で8文字以上）</label>
        <!-- 入力フォーム -->
        <input type="password" name="pass1" id="pass1" class="form-control">
      </div>

      <!-- ※確認用パスワード（送信対象） -->
      <div class="form-group col-6 mx-auto">
        <!-- バリデーション -->
        <?php if (isset($_SESSION['msg']['pass2'])) : ?>
          <p class="error"><?= $_SESSION['msg']['pass2'] ?></p>
        <?php endif ?>
        <label for="pass2">パスワード（確認用）</label>
        <!-- 入力フォーム -->
        <input type="password" name="pass2" id="pass2" class="form-control">
      </div>

      <!-- ※ボタン -->
      <div class="my-2">
        <input type="submit" value="送信" class="btn btn-primary">
        <input type="button" value="戻る" onclick="location.href='./';" class="btn btn-outline-primary">
      </div>

    </form>
  </main>

  <footer>
  </footer>
  <?php unset($_SESSION["smg"]); ?> 
</div>
</body>
</html>