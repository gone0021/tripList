<?php
  // クラスの読み込み
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/OurCalendar/html";
  require_once($root."/classes/util/SessionUtil.php");
  require_once($root."/classes/model/UsersModel.php");
  
  SessionUtil::sessionStart();

  // ※ SESSIONに保存したPOSTデータ
  // メールアドレス
  $email1 = "";
  if (!empty($_SESSION["post"]["email1"])) {
    $email1 = $_SESSION["post"]["email1"];
  }
  // パスワード
  $email2 = "";
  if (!empty($_SESSION["post"]["email2"])) {
    $email2 = $_SESSION["post"]["email2"];
  }
  // 誕生日
  $birthday = date("2020-01-01");
  if (!empty($_SESSION['post']['birthday'])) {
    $birthday = $_SESSION['post']['birthday'];
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>パスワード再設定</title>
  <link rel="stylesheet" href="../../css/normalize.css">
  <link rel="stylesheet" href="../../css/bootstrap.css">
  <link rel="stylesheet" href="../../css/main.css">
</head>

<body>
<div class="container">
  <!-- body-header -->
  <header>
    <h1 id="head-l">パスワード再設定</h1>
    <br>
    <div class="align-r-m3"><a href="../../">ログイン画面へ</a></div>
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
    <form action="./index_action.php" method="post">

    <!-- ※メールアドレス -->
    <!-- バリデーション -->
    <?php if (isset($_SESSION['msg']['email1'])) : ?>
        <p class="error"><?= $_SESSION['msg']['email1'] ?></p>
    <?php endif ?>
    <div class="form-group col-6 mx-auto mt-3">
      <label for="email1">メールアドレス</label>
      <!-- 入力フォーム -->
      <input type="text" name="email1" value="<?=$email1?>" id="email1" class="form-control">
    </div>

    <!-- ※確認用メールアドレス（送信対象） -->
    <!-- バリデーション -->
    <?php if (isset($_SESSION['msg']['email2'])) : ?>
        <p class="error"><?= $_SESSION['msg']['email2'] ?></p>
    <?php endif ?>
    <div class="form-group col-6 mx-auto">
      <label for="email2">メールアドレス（確認用）</label>
      <!-- 入力フォーム -->
      <input type="text" name="email2" value="<?=$email2?>" id="email2" class="form-control">
    </div>

       <!-- ※誕生日 -->
      <!-- バリデーション -->
      <?php if (isset($_SESSION['msg']['birthday'])) : ?>
        <p class="error"><?= $_SESSION['msg']['birthday'] ?></p>
      <?php endif ?>
      <div class="form-group col-6 mx-auto">
        <label for="birthday">誕生日</label>
        <!-- 入力フォーム -->
        <input type="date" name="birthday" value="<?=$birthday?>" id="birthday" class="form-control">
      </div>

      <!-- ※ボタン -->
      <div class="my-2">
        <input type="submit" value="確認" class="btn btn-primary">
        <input type="reset" value="リセット" class="btn btn-outline-primary">
      </div>

    </form>
    <br>
  </main>
  <?php unset($_SESSION["msg"]); ?> 

  <footer>
  </footer>
</div>
</body>
</html>