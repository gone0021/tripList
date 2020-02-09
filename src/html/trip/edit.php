<?php
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");
  require_once($root."/classes/util/CommonUtil.php");
  require_once($root."/classes/model/TripItemsModel.php");

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
  
  // サニタイズ
  $post = CommonUtil::sanitaize($_POST);

  try {
    $item = array();
    if (isset($_SESSION['post'])) {
      // POSTしたデータ
      if (!empty($_SESSION['post']['area'])) {
        $item['area'] = $_SESSION['post']['area'];
      }

      if (!empty($_SESSION['post']['point'])) {
        $item['point'] = $_SESSION['post']['point'];
      }

      if (!empty($_SESSION['post']['user_id'])) {
        $item['user_id'] = $_SESSION['post']['user_id'];
      }

      if (!empty($_SESSION['post']['date'])) {
        $item['date'] = $_SESSION['post']['date'];
      }

      if (!empty($_SESSION['post']['finished'])) {
        $item['finished'] = $_SESSION['post']['finished'];
      }

      if (!empty($_SESSION['post']['is_went'])) {
        $item['is_went'] = $_SESSION['post']['is_went'];
      }

      if (!empty($_SESSION['post']['amp_item'])) {
        $item['amp_item'] = $_SESSION['post']['amp_item'];
      }

      if (!empty($_SESSION['post']['comment'])) {
        $item['comment'] = $_SESSION['post']['comment'];
      }

    } else {
      // 指定IDの作業項目を取得
      $db = new TripItemsModel();
      $item = $db->getTripItemById($post['item_id']);
    }

    // POSTされてきたitem_idをセッションに保存
    $_SESSION['item_id'] = $post['item_id'];

  } catch (Exception $e) {
    // var_dump($e);
    header('Location: ../error.php');
  }

  $is_went = '';
  if ($item['is_went'] == 0 ) {
    $is_went = '気になる';
  } else {
    $is_went = '行った';
  }
  // POSTされてきたitem_idをセッションに保存
  $_SESSION['item_id'] = $post['item_id'];

  // var_dump($_SESSION['item_id'] );

?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>内容の更新</title>
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="container">
  <header>
      <div class="title">
        <h1>内容の更新</h1>
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

    <form action="./edit_action.php" method="post">
      <!-- ワンタイムトークンの生成 -->
    <input type="hidden" name="token" value="<?= $token ?>">
    <table class="list">
        <tr>
          <th>日時</th>
          <td class="align-l">
            <?php if (isset($_SESSION['msg']['date'])) : ?>
              <p class="error"><?= $_SESSION['msg']['date'] ?></p>
            <?php endif ?>
            <input type="date" name="date" id="date" class="date" value="<?=$item['date']?>">
          </td>
        </tr>

        <tr>
          <th>ポイント</th>
          <td class="align-l">
            <?php if (isset($_SESSION['msg']['point'])) : ?>
              <p class="error"><?= $_SESSION['msg']['point'] ?></p>
            <?php endif ?>
            <input type="text" name="point" id="point" class="point" value="<?=$item['point']?>">
          </td>
        </tr>

        <tr>
          <th>地域</th>
          <td class="align-l">
            <?php if (isset($_SESSION['msg']['area'])) : ?>
              <p class="error"><?= $_SESSION['msg']['area'] ?></p>
            <?php endif ?>
            <input type="text" name="area" id="area" class="area" value="<?=$item['area']?>">
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
            <input type="text"  name="map" id="map" class="item_name" value="<?= $item['map_item'] ?>">
            <p><a href="https://www.google.co.jp/maps/" target="blank">GoogleMap</a>から「共有→地図を埋め込む」のURLを貼り付けてください</p>
          </td>
        </tr>

        <tr>
          <th>備考</th>
          <td class="align-l">
            <?php if (isset($_SESSION['msg']['comment'])) : ?>
              <p class="error"><?= $_SESSION['msg']['comment'] ?></p>
            <?php endif ?>
            <textarea name="comment" id="comment" cols="60" rows="5" ><?= $item['comment'] ?></textarea>
          </td>
        </tr>
      </table>

      <span class="mrg-r20">
        <input type="submit" value="更新">
      </span>
      <!-- <input type="button" value="戻る" onclick=history.back()> -->
      <input type="button" value="戻る" onclick="location.href='./';">
      <br><br>

    </form>
  </main>

  <footer>
  </footer>
</div>
</body>
</html>