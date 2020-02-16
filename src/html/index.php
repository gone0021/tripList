<?php
  // クラスの読み込み
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");

  // セッションスタート
  SessionUtil::sessionStart();

  // SESSIONに保存したPOSTデータ
  $email = "";
  if (!empty($_SESSION["post"]["email"])) {
    $email = $_SESSION["post"]["email"];
  }

  // SESSIONに保存したPOSTデータを削除
  unset($_SESSION["post"]);

?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>ログイン</title>
  <link rel="stylesheet" href="./css/normalize.css">
  <link rel="stylesheet" href="./css/bootstrap.css">
  <link rel="stylesheet" href="./css/main.css">
</head>

<body>
<div class="container">
  <!-- body-header -->
  <header>
    <h1 id="head-l" class="md-3">ログイン</h1>
    <br>
    <div class="align-r-m3"><a href="./account/new/">新規登録</a></div>
  </header>

  <!-- body-main -->
  <main>
    <!-- エラーメッセージ -->
    <?php if (!empty($_SESSION["msg"]["error"])) : ?>
      <p class="error">
        <?= $_SESSION["msg"]["error"] ?>
      </p>
    <?php endif ?>

    <!-- 送信フォーム -->
    <form action="./login.php" method="post"> 
      <!-- ※メールアドレス -->
      <div class="form-group col-6 mx-auto">
        <label for="email" class="mt-3">メールアドレス</label>
        <input type="email" name="email" id="email" class="form-control" value="<?=$email?>">
      </div>

      <!-- ※パスワード -->
      <div class="form-group col-6  mx-auto">
        <label for="password" class="mt-3">パスワード</label>
        <input type="password" name="password" id="password" class="form-control">
      </div>

      <!-- ※ボタン -->
      <div class="my-2 my-3">
        <input type="submit" value="ログイン" id="login" class="btn btn-primary">
        <input type="reset" value="リセット" class="btn btn-outline-primary">
      </div>
    </form>

    <div>
      <a href="./account/pass/">パスワードを忘れた</a>
    </div>

  </main>

  <footer>
  </footer>
  <?php unset($_SESSION['msg']) ?>
</div>
</body>
</html>