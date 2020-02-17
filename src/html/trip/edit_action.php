<?php
  $root = $_SERVER["DOCUMENT_ROOT"];
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
    header('Location: ../login/');
  } else {
    // ログイン済みのとき
    $user = $_SESSION['user'];
  }

  // サニタイズ
  $post = CommonUtil::sanitaize($_POST);

  // map_itemはbase4で6エンコードされているためデコードしてdbに入れる
  $dec_map_item = '';
  $dec_map_item = base64_decode($post['map_item']);

  // データベースに登録する内容を連想配列にする。
  $data = array (
    'id' => $_SESSION['item_id'],
    'user_id' => $user['id'],
    'area' => $post['area'],
    'point' => $post['point'],
    'date' => $post['date'],
    'is_went' => $post['is_went'],
    'map_item' => $dec_map_item,
    'comment' => $post['comment'],
  );

  // アイテムの削除とエラー処理
  try {
    $db = new TripItemsModel();
    $db->updateTripItemById($data);

  } catch (Exception $e) {
    // var_dump($e);exit;
    header('Location: ../error.php');
  }

  // ページタイトル
  $title = '更新完了';
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
  <?php require_once ($root."/trip/header.php"); ?>


  <main>
    <table class="table">
      <tr>
        <th>更新が完了しました</th>
      </tr>

      <tr>
        <td>
          <a href="./">メインページへ</a>
        </td>
      </tr>
    </table>
  </main>

  <footer>
  </footer>
  <?php
    unset($_SESSION['post']); 
    unset($_SESSION['item_id']); 
  ?>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>