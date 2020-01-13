<?php
//日付の取得
$date = new DateTime("Asia/Tokyo");
$today = $date->format("Y-m-d");

// セッションスタート
session_start();
session_regenerate_id(true);

// ワンタイムトークンを生成してセッションに保存（CSRF対策）
$token = bin2hex(openssl_random_pseudo_bytes(1080));
$_SESSION['token'] = $token;

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
          <li>ユーザー名</li>
          <li>
            <form>
              <input type="button" value="ログアウト" onclick="location.href='../';">
            </form>
          </li>
        </ul>
      </div>
  </header>

  <main>
    <p class="error">
        ここにエラーの内容を表示します。
    </p>

    <!-- POST_FORM -->
    <form action="./index.html" method="post">
      <!-- ワンタイムトークンの生成 -->
      <input type="hidden" name="token" value="<?= $token ?>">

      <table class="list">
        <tr>
          <th>日時</th>
          <td class="align-l">
            <input type="date" name="date" id="date" class="date" value="<?= date("Y-m-d") ?>">
          </td>
        </tr>
        <tr>
          <th>地域</th>
          <td class="align-l">
            <input type="text" name="spot" id="item_name" class="item_name" value="登録内容をここに入力します">
          </td>
        </tr>
        <tr>
          <th>ポイント</th>
          <td class="align-l">
            <input type="text" name="point" id="item_name" class="item_name" value="登録内容をここに入力します">
          </td>
        </tr>
        <tr>
          <th>状態</th>
         <td class="align-l">
            <input type="radio" name="is_completed[<?=$v["id"] ?>]" value="went">
            <span class="mrg-r20">行った</span>
          <input type="radio" name="is_completed[<?=$v["id"] ?>]" value="want">
          気になる
        </td>
          </td>
        </tr>
        <tr>
          <th>マップ</th>
          <td class="align-l">
	
          <div class="ggmap"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3278.3198678591034!2d135.53379731454788!3d34.74753438821756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6000e3ee4650db93%3A0x1ee1514a4e67a99b!2z5Ymy54O5IOasoeWFgw!5e0!3m2!1sja!2sjp!4v1578385964210!5m2!1sja!2sjp" width="600" height="500" frameborder="0" style="border:0;" allowfullscreen=""></iframe></div>
          </td>
        </tr>
        <tr>
          <th>備考</th>
          <td class="align-l">
            <textarea name="comment" id="comment" cols="60" rows="5"></textarea>
          </td>
        </tr>
      </table>

      <span class="mrg-r20">
        <input type="submit" value="更新">
      </span>
      <input type="button" value="キャンセル" onclick="location.href='./index.html';">
      <br><br>
    </form>
  </main>

  <footer>

  </footer>
</div>
</body>
</html>