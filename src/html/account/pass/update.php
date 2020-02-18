<?php
  // クラスの読み込み
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");
  
  SessionUtil::sessionStart();

  $token = bin2hex(openssl_random_pseudo_bytes(108));
  $_SESSION['token'] = $token;

  // ページタイトル
  $title = 'パスワードの再設定';
?>

<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title> <?= $title ?> </title>
  <link rel="stylesheet" href="../../css/normalize.css">
  <link rel="stylesheet" href="../../css/bootstrap.css">
  <link rel="stylesheet" href="../../css/main.css">
</head>

<body>
<div class="container">
  <!-- body-header -->
  <?php require_once ($root."./account/header.php"); ?>

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
        <input type="submit" value="送信" class="btn btn-outline-primary">
        <input type="button" value="戻る" onclick="location.href='./';" class="btn btn-outline-primary">
      </div>

    </form>
  </main>

  <footer>
  </footer>
  <?php unset($_SESSION["smg"]); ?> 
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>