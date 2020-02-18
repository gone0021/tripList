<?php
  // クラスの読み込み
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");

  // セッションスタート
  SessionUtil::sessionStart();

  // トークンの生成
  $token = bin2hex(openssl_random_pseudo_bytes(108));
  $_SESSION['token'] = $token;

  // ※ SESSIONに保存したPOSTデータ（パスワードは保存しない）
  // ユーザー名
  $name = "";
  if (!empty($_SESSION['post']['name'])) {
    $name =  $_SESSION['post']['name'];
  }
  // メールアドレス
  $email = "";
  if (!empty($_SESSION['post']['email'])) {
    $email = $_SESSION['post']['email'];
  }
  // 誕生日
  $birthday = date("2020-01-01");
  if (!empty($_SESSION['post']['birthday'])) {
    $birthday = $_SESSION['post']['birthday'];
  }

  // var_dump($root);
  
  // ページタイトル
  $title = '新規ユーザー登録';
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
    <form action="./check.php" method="post">
      <!-- トークンの送信 -->
      <input type="hidden" name="token" value="<?= $token ?>">

      <!-- ※ユーザー名 -->
      <div class="form-group col-6 mx-auto mt-3">
        <!-- バリデーション -->
        <?php if (isset($_SESSION['msg']['name'])) : ?>
          <p class="error"><?= $_SESSION['msg']['name'] ?></p>
        <?php endif ?>
        <!-- 入力フォーム -->
        <label for="name">ユーザー名</label>
        <input type="text" name="name" value="<?=$name?>" id="name" class="form-control">
      </div>

      <!-- ※メールアドレス -->
      <div class="form-group col-6 mx-auto">
        <!-- バリデーション -->
        <?php if (isset($_SESSION['msg']['email'])) : ?>
            <p class="error"><?= $_SESSION['msg']['email'] ?></p>
        <?php endif ?>
        <!-- 入力フォーム -->
        <label for="email">メールアドレス</label>
        <input type="text" name="email" value="<?=$email?>" id="email" class="form-control">
      </div>

      <!-- ※誕生日 -->
      <div class="form-group col-6 mx-auto">
        <!-- バリデーション -->
        <?php if (isset($_SESSION['msg']['birthday'])) : ?>
          <p class="error"><?= $_SESSION['msg']['birthday'] ?></p>
        <?php endif ?>
        <!-- 入力フォーム -->
        <label for="birthday">誕生日（パスワードの再設定に使用）</label>
        <input type="date" name="birthday" value="<?=$birthday?>" id="birthday" class="form-control">
      </div>

      <!-- ※パスワード -->
      <div class="form-group col-6 mx-auto">
        <!-- バリデーション -->
        <?php if (isset($_SESSION['msg']['pass1'])) : ?>
          <p class="error"><?= $_SESSION['msg']['pass1'] ?></p>
        <?php endif ?>
        <!-- 入力フォーム -->
        <label for="pass1">パスワード（半角英数字で8文字以上）</label>
        <input type="password" name="pass1" id="pass1" class="form-control">
      </div>

      <!-- ※確認用パスワード（送信対象） -->
      <div class="form-group col-6 mx-auto">
        <!-- バリデーション -->
        <?php if (isset($_SESSION['msg']['pass2'])) : ?>
          <p class="error"><?= $_SESSION['msg']['pass2'] ?></p>
        <?php endif ?>
        <!-- 入力フォーム -->
        <label for="pass2">パスワード（確認用）</label>
        <input type="password" name="pass2" id="pass2" class="form-control">
      </div>

      <!-- ※ボタン -->
      <div class="my-2 my-3">
        <input type="submit" value="確認" class="btn btn-outline-primary">
        <input type="reset" value="リセット" class="btn btn-outline-primary">
      </div>

    </form>

    <div class="mb-3">
      <a href="../pass/">パスワードを忘れた</a>
    </div>
    
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