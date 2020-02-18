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

  // ページタイトル
  $title = 'ログイン';
?>

<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title> <?= $title ?> </title>
  <link rel="stylesheet" href="./css/normalize.css">
  <link rel="stylesheet" href="./css/bootstrap.css">
  <link rel="stylesheet" href="./css/main.css">
</head>

<body>
<div class="container">
  <!-- body-header -->
  <?php require_once ($root."./header.php"); ?>

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
        <input type="submit" value="ログイン" id="login" class="btn btn-outline-primary">
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

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>