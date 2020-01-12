<?php
  // require_once("../classes/util/SessionUtil.php");

  // クラスの読み込み
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/OurCalendar/html";
  require_once($root."/classes/util/SessionUtil.php");

  // var_dump($root);

  // セッションスタート
  SessionUtil::sessionStart();

  // セッション変数に保存したPOSTデータ
  $user = "";
  if (!empty($_SESSION["post"]["user"])) {
    $user = $_SESSION["post"]["user"];
  }

  // セッション変数に保存したPOSTデータを削除
  unset($_SESSION["post"]);
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
    <div class="align-r-m3"><a href="../">ログイン画面へ</a></div>
  </header>

  <main>
    <!-- ログイン処理 -->
    <form action="./login.php" method="post">
      <table class="login">

        <tr>
          <th class="login_field">
            パスワード
          </th>
          <td class="login_field">
            <input type="text" name="user" id="user" class="login_user" value="<?=$user?>">
          </td>
        </tr>

        <tr>
          <th class="login_field">
            パスワード（確認用）
          </th>
          <td class="login_field">
            <input type="password" name="password" id="password" class="login_pass">
          </td>
        </tr>

      </table>
      <input type="submit" value="設定"" id="setting">
    </form>
    <br><br><br>
    設定完了：<a href="../">ログイン画面へ</a>
  </main>

  <footer>
  </footer>
</div>
</body>
</html>