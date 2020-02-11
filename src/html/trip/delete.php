<?php
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");
  require_once($root."/classes/util/CommonUtil.php");
  require_once($root."/classes/model/TripItemsModel.php");

  // セッションスタート
  SessionUtil::sessionStart();

  if (empty($_SESSION['user'])) {
    // 未ログインのとき
    header('Location: ../');
  } else {
    // ログイン済みのとき
    $user = $_SESSION['user'];
  }
  
  // サニタイズ
  $post = CommonUtil::sanitaize($_POST);

  try {
    // 指定IDの作業項目を取得
    $db = new TripItemsModel();
    $items = $db->getTripItemById($post['item_id']);

  } catch (Exception $e) {
    // var_dump($e);
    header('Location: ../error.php');
  }

  $is_went = '';
  if ($items['is_went'] == 0 ) {
    $is_went = '気になる';
  } else {
    $is_went = '行った';
  }
  // POSTされてきたitem_idをセッションに保存
  $_SESSION['post']['item_id'] = $post['item_id'];

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<title>削除確認</title>
<link rel="stylesheet" href="../css/normalize.css">
<link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="container">
  <header>
    <div class="title">
      <h1>削除確認</h1>
    </div>
    <div class="login_info">
      <ul>
      <li>ようこそ<?=$user['name']?>さん</li>
        <li>
          <form>
            <input type="button" value="ログアウト" onclick="location.href='../login/index.html';">
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

    <p>
      下記の項目を削除します。よろしいですか？
    </p>
    <form action="./delete_action.php" method="post">
      <table class="list">
        <tr>
          <th>日時</th>
          <td class="align-l">
            <?= $items['date'] ?>
          </td>
        </tr>
        <tr>
          <th>ポイント</th>
          <td class="align-l">
            <?= $items['point'] ?>
          </td>
        </tr>
        <tr>
          <th>地域</th>
          <td class="align-l">
            <?= $items['area'] ?>
          </td>
        </tr>
        <tr>
          <th>状態</th>
         <td class="align-l">
           <?= $is_went ?>
        </td>
          </td>
        </tr>
        <tr>
          <th>マップ</th>
          <td class="align-l ggmap">
            <?= $items['map_item'] ?>
          </td>
        </tr>
        <tr>
          <th>備考</th>
          <td class="align-l">
            <?= $items['comment'] ?>
          </td>
        </tr>
      </table>

      <span class="mrg-r20">
        <input type="submit" value="削除">
      </span>
      <input type="button" value="戻る" onclick="location.href='./';">
      <br><br>

    </form>
  </main>

  <footer>
  </footer>
</div>
</body>
</html>