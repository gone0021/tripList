<?php
  // クラスの読み込み
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");
  
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
        <input type="submit" value="確認" class="btn btn-outline-primary">
        <input type="reset" value="リセット" class="btn btn-outline-primary">
      </div>

    </form>
    <br>
  </main>
  <?php unset($_SESSION["msg"]); ?> 

  <footer>
  </footer>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>