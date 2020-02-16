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
  
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>新規登録</title>
  <!-- <link rel="stylesheet" href="../../css/bootstrap.css"> -->
  <link rel="stylesheet" href="../../css/normalize.css">
  <link rel="stylesheet" href="../../css/bootstrap.css">
  <link rel="stylesheet" href="../../css/main.css">
</head>

<body>
<div class="container">
  <!-- body-header -->
  <header>
    <h1 id="head-l">新規登録</h1>
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
      <div class="my-2">
        <input type="submit" value="確認" class="btn btn-primary">
        <input type="reset" value="リセット" class="btn btn-outline-primary">
      </div>

    </form>

    <br>
    <div>
      <a href="../pass/">パスワードを忘れた</a>
    </div>
    
  </main>

  <footer>
  </footer>
  <?php unset($_SESSION["smg"]); ?> 
</div>
</body>
</html>