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
  <link rel="stylesheet" href="../../css/main.css">
</head>

<body>
<div class="container">
  <main>
    <header>
      <h1 id="head-l">パスワードの再設定</h1>
    </header>

    <!-- 完了時の処理 -->
    <form action="./update_action.php" method="post">
      <input type="hidden" name="token" value="<?= $token ?>">

      <table class="login">
        <tr>
          <th class="login_field">
            メールアドレス
          </th>
          <td class="login_field">
            <?=$_SESSION["email2"]?>
            <input type="hidden" name="email" value="<?=$_SESSION["email2"]?>">
          </td>
        </tr>

        <?php if (isset($_SESSION['msg']['pass1'])) : ?>
          <tr>
            <th></th>
            <td>
              <p class="error"><?= $_SESSION['msg']['pass1'] ?></p>
            </td>
          </tr>
        <?php endif ?>
        <tr>
          <th class="login_field">
            パスワード<br>（半角英数字で8文字以上）
          </th>
          <td class="login_field">
            <input type="password" name="pass1" id="pass1" class="login_box">
          </td>
        </tr>

        <?php if (isset($_SESSION['msg']['pass2'])) : ?>
          <tr>
            <th></th>
            <td>
              <p class="error"><?= $_SESSION['msg']['pass2'] ?></p>
            </td>
          </tr>
        <?php endif ?>
        <tr>
          <th class="login_field">
            パスワード（確認用）
          </th>
          <td class="login_field">
            <input type="password" name="pass2" id="pass2" class="login_box">
          </td>
        </tr>
      </table>
      <input type="submit" value="送信" id="add">
      <input type="button" value="戻る" onclick="location.href='./';">
    </form>
  </main>

  <footer>
  </footer>
  <?php unset($_SESSION["smg"]); ?> 
</div>
</body>
</html>