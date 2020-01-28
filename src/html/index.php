<?php
  // クラスの読み込み
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");

  // セッションスタート
  SessionUtil::sessionStart();

  // require_once($root."/classes/model/UsersModel.php");
  // $db = new UsersModel();
  // $user = $db->checkPassForEmail($_SESSION["post"]["email"], $_SESSION["post"]["password"]);

  // セッション変数に保存したPOSTデータ
  $email = "";
  if (!empty($_SESSION["post"]["email"])) {
    $email = $_SESSION["post"]["email"];
  }

  // var_dump($_SESSION["post"]["email"]);
  // echo '<br>';
  // var_dump($_SESSION["post"]["password"]);
  // echo '<br>';
  // var_dump($user);


  // セッション変数に保存したPOSTデータを削除
  unset($_SESSION["post"]);

?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>ログイン</title>
  <link rel="stylesheet" href="./css/normalize.css">
  <link rel="stylesheet" href="./css/main.css">
</head>

<body>
<div class="container">
  <header>
    <h1 id="head-l">ログイン</h1>
    <br>
    <div class="align-r-m3"><a href="./account/new/">新規登録</a></div>
  </header>

  <main>
    <!-- エラー時の処理 -->
    <?php if (!empty($_SESSION["msg"]["error"])) : ?>
      <p class="error">
        <?= $_SESSION["msg"]["error"] ?>
      </p>
    <?php endif ?>

    <!-- ログイン処理 -->
    <form action="./login.php" method="post">
      <table class="login">
        <tr>
          <th class="login_field">
            メールアドレス
          </th>
          <td class="login_field">
            <input type="email" name="email" id="email" class="login_email" value="<?=$email?>">
          </td>
        </tr>

        <tr>
          <th class="login_field">
            パスワード
          </th>
          <td class="login_field">
            <input type="password" name="password" id="password" class="login_box">
          </td>
        </tr>

      </table>
      <input type="submit" value="ログイン" id="login">
    </form>

    <br><br><br>
    <a href="./account/pass/">パスワードを忘れた</a>
  </main>

  <footer>
  </footer>
  <?php unset($_SESSION["msg"]); ?>
</div>
</body>
</html>