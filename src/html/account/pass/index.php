<?php
  // クラスの読み込み
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/OurCalendar/html";
  require_once($root."/classes/util/SessionUtil.php");
  require_once($root."/classes/model/UsersModel.php");
  
  SessionUtil::sessionStart();

  // セッション変数に保存したPOSTデータ
  $email1 = "";
  if (!empty($_SESSION["post"]["email1"])) {
    $email1 = $_SESSION["post"]["email1"];
  }

  $email2 = "";
  if (!empty($_SESSION["post"]["email2"])) {
    $email2 = $_SESSION["post"]["email2"];
  }

  $birthday = date("");
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
  <link rel="stylesheet" href="../../css/main.css">
</head>

<body>
<div class="container">
  <header>
    <h1 id="head-l">パスワード再設定</h1>
    <br>
    <div class="align-r-m3"><a href="../../">ログイン画面へ</a></div>
  </header>

  <main>
    <!-- エラー時の処理 -->
    <?php if (!empty($_SESSION["msg"]["error"])) : ?>
      <p class="error">
        <?= $_SESSION["msg"]["error"] ?>
      </p>
    <?php endif ?>

    <!-- 確認処理 -->
    <form action="./index_action.php" method="post">
      <table class="login">

        <?php if (isset($_SESSION['msg']['email1'])) : ?>
          <tr>
            <th></th>
            <td>
              <p class="error"><?= $_SESSION['msg']['email1'] ?></p>
            </td>
          </tr>
        <?php endif ?>
        <tr>
          <th class="login_field">
            メールアドレス
          </th>
          <td class="login_field">
            <input type="email" name="email1" id="email1" class="login_email" value="<?=$email1?>">
          </td>
        </tr>

        <?php if (isset($_SESSION['msg']['email2'])) : ?>
          <tr>
            <th></th>
            <td>
              <p class="error"><?= $_SESSION['msg']['email2'] ?></p>
            </td>
          </tr>
        <?php endif ?>
        <tr>
          <th class="login_field">
            メールアドレス（確認用）
          </th>
          <td class="login_field">
            <input type="email" name="email2" id="email2" class="login_email" value="<?=$email2?>">
          </td>
        </tr>

        <tr>
          <th></th>
          <?php if (isset($_SESSION['msg']['birthday'])) : ?>
            <td>
              <p class="error"><?= $_SESSION['msg']['birthday'] ?></p>
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

      </table>
      <input type="submit" value="確認" id="check">
    </form>
    <br>
  </main>

  <footer>
  </footer>
</div>
</body>
</html>