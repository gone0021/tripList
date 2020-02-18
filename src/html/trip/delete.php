<?php
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");
  require_once($root."/classes/util/CommonUtil.php");
  require_once($root."/classes/model/TripItemsModel.php");

  // セッションスタート
  SessionUtil::sessionStart();

  // ログインの確認
  // $_SESSION['user']：ログイン時に取得したユーザー情報
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

  // 気になる、行ったの文字列置き換え
  $str_went = '';
  if (isset($post['is_went']) && $post['is_went'] == 0 ) {
    $str_went = '気になる';
  } else {
    $str_went = '行った';
  }

  // POSTされてきたitem_idをセッションに保存
  $_SESSION['post']['item_id'] = $post['item_id'];

  // ページタイトル
  $title = '削除確認';
?>

<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title> <?= $title ?> </title>
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/main.css">
</head>

<body>
<div class="container">
  <!-- body-header -->
  <?php require_once ($root."./trip/header.php"); ?>


  <!-- body-main -->
  <main>
    <p class="mt-5">
      下記の項目を削除します。よろしいですか？
    </p>
    <!-- 送信フォーム -->
    <form action="./delete_action.php" method="post">
      <table class="table">
        <!-- ※日時：date -->
        <tr>
          <th scope="row">日時</th>
          <td class="align-l">
            <?= $items['date'] ?>
          </td>
        </tr>

        <!-- ※ポイント：point -->
        <tr>
          <th scope="row">ポイント</th>
          <td class="align-l">
            <?= $items['point'] ?>
          </td>
        </tr>

        <!-- ※地域：area -->
        <tr>
          <th scope="row">地域</th>
          <td class="align-l">
            <?= $items['area'] ?>
          </td>
        </tr>

        <!-- ※状態：is_went -->
        <tr>
          <th scope="row">状態</th>
          <td class="align-l">
            <?= $str_went ?>
          </td>
        </tr>

        <!-- ※マップ：map -->
        <tr>
          <th scope="row">マップ</th>
          <td class="align-l ggmap">
            <?= $items['map_item'] ?>
          </td>
        </tr>

        <!-- ※備考：comment -->
        <tr>
          <th scope="row">備考</th>
          <td class="align-l">
            <?= $items['comment'] ?>
          </td>
        </tr>
      </table>

      <!-- ※ボタン -->
      <div class="mb-5">
        <span class="mr-3">
          <input type="submit" value="削除" class="btn btn-outline-primary">
        </span>
        <input type="button" value="戻る" onclick="location.href='./';" class="btn btn-outline-primary">
      </div>

    </form>
  </main>

  <footer>
  </footer>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>