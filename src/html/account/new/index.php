<?php
  // クラスの読み込み
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");

  // セッションスタート
  SessionUtil::sessionStart();

  $token = bin2hex(openssl_random_pseudo_bytes(108));
  $_SESSION['token'] = $token;

  // セッションに保存したPOSTデータ
  $name = "";
  if (!empty($_SESSION['post']['name'])) {
    $name =  $_SESSION['post']['name'];
  }

  $email = "";
  if (!empty($_SESSION['post']['email'])) {
    $email = $_SESSION['post']['email'];
  }

  $birthday = date("");
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
  <link rel="stylesheet" href="../../css/normalize.css">
  <link rel="stylesheet" href="../../css/main.css">
</head>

<body>
<div class="container">
  <header>
    <h1 id="head-l">新規登録</h1>
    <br>
    <div class="align-r-m3"><a href="../../">ログイン画面へ</a></div>
  </header>

  <main>
    <!-- トークンチェックのエラーメッセージ -->
    <?php if (isset($_SESSION['err_msg']['err'])) : ?>
      <p class="warning"><?= $_SESSION['err_msg']['err'] ?></p>
    <?php endif ?>

    <!-- 登録内容の確認へ -->
    <form action="./check.php" method="post">
      <!-- ワンタイムトークンの生成 -->
      <input type="hidden" name="token" value="<?= $token ?>">

      <table class="login">
        <tr>
          <th></th>
          <?php if (isset($_SESSION['err_msg']['name'])) : ?>
            <td>
              <p class="error"><?= $_SESSION['err_msg']['name'] ?></p>
            </td>
          <?php endif ?>
        </tr>
        <tr>
          <th class="login_field">
            ユーザー名
          </th>
          <td class="login_field">
            <input type="text" name="name" id="name" class="login_box" value="<?=$name?>">
          </td>
        </tr>

        <tr>
          <th></th>
          <?php if (isset($_SESSION['err_msg']['email'])) : ?>
            <td>
              <p class="error"><?= $_SESSION['err_msg']['email'] ?></p>
            </td>
          <?php endif ?>
        </tr>
        <tr>
          <th class="login_field">
            メールアドレス
          </th>
          <td class="login_field">
            <input type="email" name="email" id="email" class="login_email" value="<?=$email?>">
          </td>
        </tr>

        <tr>
          <th></th>
          <?php if (isset($_SESSION['err_msg']['birthday'])) : ?>
            <td>
              <p class="error"><?= $_SESSION['err_msg']['birthday'] ?></p>
            </td>
          <?php endif ?>
        </tr>
        <tr>
          <th class="login_field">
            誕生日
          </th>
          <td class="login_field">
            <input type="date" name="birthday" id="birthday" class="login_box" value="<?=$birthday?>">
          </td>
        </tr>
        <tr>
          <th></th>
          <td>※ パスワードの再設定に使用</td>
        </tr>

        <tr>
          <th></th>
          <?php if (isset($_SESSION['err_msg']['pass1'])) : ?>
            <td>
              <p class="error"><?= $_SESSION['err_msg']['pass1'] ?></p>
            </td>
          <?php endif ?>
        </tr>
        <tr>
          <th class="login_field">
            パスワード（6文字以上）
          </th>
          <td class="login_field">
            <input type="password" name="pass1" id="pass1" class="login_box">
            </td>
        </tr>

        <tr>
          <th></th>
          <?php if (isset($_SESSION['err_msg']['pass2'])) : ?>
            <td>
              <p class="error"><?= $_SESSION['err_msg']['pass2'] ?></p>
            </td>
          <?php endif ?>
        </tr>
        <tr>
          <th class="login_field">
            パスワード（確認用）
          </th>
          <td class="login_field">
            <input type="password" name="pass2" id="pass2" class="login_box">
          </td>
        </tr>

      </table>
      <input type="submit" value="確認" id="add">
    </form>
    <br>
    <a href="./pass/">パスワードを忘れた</a>
  </main>

  <footer>
  </footer>
</div>
</body>
</html>