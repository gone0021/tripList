<?php
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");
  require_once($root."/classes/util/CommonUtil.php");

  //日付の取得
  $date = new DateTime("Asia/Tokyo");
  $today = $date->format("Y-m-d");

  // トークンの生成
  $token = bin2hex(openssl_random_pseudo_bytes(108));
  $_SESSION['token'] = $token;

  // セッションスタート
  SessionUtil::sessionStart();

  // ログインの確認
  // $user = $db->checkPassForEmail($post["email"], $post["password"]); メールアドレスとパスワードからユーザー情報を検索
  if (empty($_SESSION['name'])) {
    // 未ログインのとき
    header('Location: ../');
  } else {
    // ログイン済みのとき
    $user = $_SESSION['name'];
  }

  // セッションに保存したPOSTデータ
  $date = date('Y-m-d');
  if (!empty($_SESSION['post']['date'])) {
      $date = $_SESSION['post']['date'];
  }

  $area = '';
  if (!empty($_SESSION['post']['area'])) {
      $area =  $_SESSION['post']['area'];
  }

  $point = '';
  if (!empty($_SESSION['post']['point'])) {
      $point = $_SESSION['post']['point'];
  }

  $map = '';
  if (!empty($_SESSION['post']['map'])) {
      $map = $_SESSION['post']['map'];
  }

  $comment = '';
  if (!empty($_SESSION['post']['comment'])) {
      $comment = $_SESSION['post']['comment'];
  }

  $is_went = '';
  if (!empty($_SESSION['post']['is_went'])) {
      $is_went = $_SESSION['post']['is_went'];
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>新規登録</title>
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="container">
  <header>
      <div class="title">
        <h1>新規登録</h1>
      </div>

      <div class="login_info">
        <ul>
          <li>
            ようこそ<?=$user['name'] ?>さん
          </li>
  
          <li>
            <form>
              <input type="button" value="ログアウト" onclick="location.href='../logout.php';">
            </form>
          </li>
        </ul>
      </div>
  </header>

  <main>
    <?php if (!empty($_SESSION['msg']['error'])): ?>
        <p class="error">
            <?=$_SESSION['msg']['error']?>
        </p>
    <?php endif ?>
  
    <!-- POST_FORM -->
    <form action="./new_action.php" method="post">
      <!-- ワンタイムトークンの生成 -->
      <input type="hidden" name="token" value="<?= $token ?>">

      <table class="list">
        <tr>
          <th>日時</th>
          <td class="align-l">
            <?php if (isset($_SESSION['msg']['date'])) : ?>
              <p class="error"><?= $_SESSION['msg']['date'] ?></p>
            <?php endif ?>
            <input type="date" name="date" id="date" class="date" value="<?= $date ?>">
          </td>
        </tr>

        <tr>
          <th>ポイント</th>
          <td class="align-l">
            <?php if (isset($_SESSION['msg']['point'])) : ?>
              <p class="error"><?= $_SESSION['msg']['point'] ?></p>
            <?php endif ?>
            <input type="text" name="point" id="point" class="item_name" value="<?= $point ?>">
          </td>
        </tr>

        <tr>
          <th>地域</th>
          <td class="align-l">
            <?php if (isset($_SESSION['msg']['area'])) : ?>
              <p class="error"><?= $_SESSION['msg']['area'] ?></p>
            <?php endif ?>
            <input type="text" name="area" id="area" class="item_name" value="<?= $area ?>">
          </td>
        </tr>

        <tr>
          <th>状態</th>
         <td class="align-l">
          <input type="radio" name="is_went" value="0"<?php if ($is_went == 0) echo " checked" ?>>
          <span class="mrg-r20">気になる</span>
          <input type="radio" name="is_went" value="1"<?php if ($is_went == 1) echo " checked" ?>>
          行った
        </td>
          </td>
        </tr>

        <tr>
          <th>マップ</th>
          <td class="align-l ggmap">
            <?php if (isset($_SESSION['msg']['map'])) : ?>
              <p class="error"><?= $_SESSION['msg']['map'] ?></p>
            <?php endif ?>
            <input type="text"  name="map" id="map" class="item_name" value="<?= $map ?>">
            <p><a href="https://www.google.co.jp/maps/" target="blank">GoogleMap</a>から「共有→地図を埋め込む」のURLを貼り付けてください</p>
          </td>
        </tr>

        <tr>
          <th>備考</th>
          <td class="align-l">
            <?php if (isset($_SESSION['msg']['comment'])) : ?>
              <p class="error"><?= $_SESSION['msg']['comment'] ?></p>
            <?php endif ?>
            <textarea name="comment" id="comment" cols="60" rows="5" ><?= $comment ?></textarea>
          </td>
        </tr>
      </table>

      <span class="mrg-r20">
        <input type="submit" value="確認">
      </span>
      <input type="button" value="キャンセル" onclick="location.href='./';">
      <br><br>
    </form>
  </main>

  <footer>

  </footer>
  <?php   
    unset($_SESSION['msg']); 
  ?>
</div>
</body>
</html>