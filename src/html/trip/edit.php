<?php
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");
  require_once($root."/classes/util/CommonUtil.php");
  require_once($root."/classes/model/TripItemsModel.php");

  // セッションスタート
  SessionUtil::sessionStart();

  // トークンの生成
  $token = bin2hex(openssl_random_pseudo_bytes(108));
  $_SESSION['token'] = $token;

  // ログインの確認
  // $_SESSION['user']：ログイン時に取得したユーザー情報
  if (empty($_SESSION['user'])) {
    // 未ログインのとき
    header('Location: ../');
  } else {
    // ログイン済みのとき
    $user = $_SESSION['user'];
  }
  
  // サニタイズ（postで必要なのはtrip_itemsのidのみ）
  $post = CommonUtil::sanitaize($_POST);

  try {
    $items = array();
    // SESSIONに保存したPOSTデータの呼び出し
    if (isset($_SESSION['post'])) {
      // ユーザーID
      if (!empty($_SESSION['post']['user_id'])) {
        $items['user_id'] = $_SESSION['post']['user_id'];
      }
      // 日付
      if (!empty($_SESSION['post']['date'])) {
        $items['date'] = $_SESSION['post']['date'];
      }
      // ポイント
      if (!empty($_SESSION['post']['point'])) {
        $items['point'] = $_SESSION['post']['point'];
      }
      // 地域
      if (!empty($_SESSION['post']['area'])) {
        $items['area'] = $_SESSION['post']['area'];
      }
      // 行った、気になる（行きたいの場合が「0」のためissetで判定）
      if (isset($_SESSION['post']['is_went'])) {
        $items['is_went'] = $_SESSION['post']['is_went'];
      }
      // マップ
      if (!empty($_SESSION['post']['map_item'])) {
        $items['map_item'] = $_SESSION['post']['map_item'];
      }
      // 備考（コメントは無記入でOKのため見つからない場合に無記入を上書き）
      if (!empty($_SESSION['post']['comment'])) {
        $items['comment'] = $_SESSION['post']['comment'];
      } else {
        $items['comment'] = '';
      }
    } else {
      // 指定IDの作業項目を取得
      $db = new TripItemsModel();
      $items = $db->getTripItemById($post['item_id']);
    }

  } catch (Exception $e) {
    // var_dump($e);
    header('Location: ../error.php');
  }

  // POSTされてきたitem_idをSESSIONに保存
  if (!empty($_SESSION['item_id'])) {
    $_SESSION['item_id'] = $_SESSION['item_id'];
  } else {
    $_SESSION['item_id'] = $post['item_id'];
  }

  // var_dump($_SESSION['post']);
  // var_dump($_SESSION['item_id'] );

  // ページタイトル
  $title = '内容の更新';
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
    <!-- エラーメッセージ -->
    <?php if (!empty($_SESSION['msg']['error'])): ?>
      <p class="error">
        <?=$_SESSION['msg']['error']?>
      </p>
    <?php endif ?>

    <!-- 送信フォーム -->
    <form action="./edit_check.php" method="post">
      <!-- トークンの送信 -->
      <input type="hidden" name="token" value="<?= $token ?>">
      <table class="table">
        <!-- ※日時：date -->
        <tr>
          <th scope="row" class="pt-4">日時</th>
          <td class="align-l">
            <!-- バリデーション -->
            <?php if (isset($_SESSION['msg']['date'])) : ?>
              <p class="error"><?= $_SESSION['msg']['date'] ?></p>
            <?php endif ?>
            <!-- 入力フォーム -->
            <input type="date" name="date" value="<?=$items['date']?>" id="date" class="form-control">
          </td>
        </tr>

        <!-- ※ポイント：point -->
        <tr>
          <th scope="row" class="pt-4">ポイント</th>
          <td class="align-l">
            <!-- バリデーション -->
            <?php if (isset($_SESSION['msg']['point'])) : ?>
              <p class="error"><?= $_SESSION['msg']['point'] ?></p>
            <?php endif ?>
            <!-- 入力フォーム -->
            <input type="text" name="point" value="<?=$items['point']?>" id="point" class="form-control">
          </td>
        </tr>

        <!-- ※地域：area -->
        <tr>
          <th scope="row" class="pt-4">地域</th>
          <td class="align-l">
            <!-- バリデーション -->
            <?php if (isset($_SESSION['msg']['area'])) : ?>
              <p class="error"><?= $_SESSION['msg']['area'] ?></p>
            <?php endif ?>
            <!-- 入力フォーム -->
            <input type="text" name="area" value="<?=$items['area']?>" id="area" class="form-control">
          </td>
        </tr>

        <!-- ※状態：is_went -->
        <tr>
          <th scope="row" class="">状態</th>
         <td class="align-l">
            <input type="radio" name="is_went" value="0" <?php if ($items['is_went'] == 0) echo "checked" ?> id="want" class="">
            <label for="want" class="mr-3">気になる</label>
            <input type="radio" name="is_went"  value="1"<?php if ($items['is_went'] == 1) echo "checked" ?> id="went" class="">
            <label for="went">行った</label>
        </td>
          </td>
        </tr>

        <!-- ※マップ：map -->
        <tr>
          <th scope="row" class="pt-4">マップ</th>
          <td class="align-l ggmap">
            <!-- バリデーション -->
            <?php if (isset($_SESSION['msg']['map_item'])) : ?>
              <p class="error"><?= $_SESSION['msg']['map_item'] ?></p>
            <?php endif ?>
            <!-- 元のマップ情報 -->
            <?php
              if (isset( $_SESSION['post']['map_item'])) {
                echo $_SESSION['post']['map_item'];
              } else {
              echo $items['map_item']; 
              }
            ?>
            <p class="mt-3"><label for="map_item">※ 以下に新しい位置情報を入力してください</label></p>
            <!-- 入力フォーム -->
            <!-- googlemapから位置情報を取得するためsessionを取らずvalueを入れない（""で囲まれている範囲がるためうまく表示できない） -->
            <input type="text"  name="map_item" id="map_item" value="" class="form-control">
            <p><a href="https://www.google.co.jp/maps/" target="blank">GoogleMap</a>から「共有→地図を埋め込む」のURLを貼り付けてください</p>
          </td>
        </tr>

        <!-- ※備考：comment -->
        <tr>
          <th scope="row" class="pt-3">備考</th>
          <td class="align-l">
            <!-- バリデーション -->
            <?php if (isset($_SESSION['msg']['comment'])) : ?>
              <p class="error"><?= $_SESSION['msg']['comment'] ?></p>
            <?php endif ?>
            <!-- 入力フォーム -->
            <textarea name="comment" id="comment" class="form-control" cols="60" rows="5" ><?= $items['comment'] ?></textarea>
          </td>
        </tr>
      </table>

      <!-- ※ボタン -->
      <div class="mb-5">
        <span class="mr-3">
          <input type="submit" value="更新" class="btn btn-outline-primary">
        </span>
        <!-- <input type="button" value="戻る" onclick=history.back()> -->
        <input type="button" value="戻る" onclick="location.href='./';" class="btn btn-outline-primary">
      </div>

    </form>
  </main>

  <footer>
  </footer>
  <?php   
    unset($_SESSION['msg']); 
  ?>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>