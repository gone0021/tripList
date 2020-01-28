<?php
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");
  require_once($root."/classes/util/CommonUtil.php");
  require_once($root."/classes/model/TripItemsModel.php");

  // セッションスタート
  SessionUtil::sessionStart();

  // 設定済みのセッションに保存されたPOSTデータを削除
  unset($_SESSION['post']);

  // ログインの確認
  // $user = $db->checkPassForEmail($post["email"], $post["password"]); メールアドレスとパスワードからユーザー情報を検索
  if (empty($_SESSION['name'])) {
    // 未ログインのとき
    header('Location: ../');
  } else {
    // ログイン済みのとき
    $user = $_SESSION['name'];
  }

  // var_dump($post['id']);

  try {
    $db = new TripItemsModel();

    // 通常の一覧表示または検索結果かを保存するフラグ
    $isSearch = false;

    // 検索キーワード
    $search = "";

    if (isset($_GET['search'])) {
      // GETに項目があるときは検索
      $get = CommonUtil::sanitaize($_GET);
      $search = $get['search'];
      $isSearch = true;
      $items = $db->getTripItemBySearch($search);
    } else {
      // GETに項目がないときは、作業項目を全件取得
      $items = $db->getTripItemAll();
    }

  } catch (Exception $e) {
    var_dump($e);exit;
    header('Location: ../error.php');
  }

  // 奇数行(odd)・偶数行(even)の判定用カウンタ
  $line = 0;
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>リスト一覧</title>
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/main.css">
</head>

<body>
<div class="container">
  <header>
    <div class="title">
      <h1>リスト一覧</h1>
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
    <div class="main-header">
      <!-- main header GET -->
      <form action="./" method="get">
        <!-- 新規登録ボタン -->
        <div class="entry">
          <input type="button" name="entry-button" id="entry-button" class="entry-button" value="作業登録" onclick="location.href='./new.php'">
        </div>

        <!-- 検索フォーム -->
        <div class="search">
          <input type="text" name="search" id="search">
          <input type="submit" value="🔍検索">
        </div>
      </form>
    </div>

    <!-- タイトル -->
    <table class="list">
      <tr>
        <th>ポイント名</th>
        <th>日付</th>
        <th>登録者</th>
        <th>状態</th>
        <th>操作</th>
      </tr>

    <!-- 行数チェック -->
    <?php
      foreach ($items as $item):
        if ($line % 2 == 0) {
          $class = "even";
        } else {
          $class = "odd";
        }

        // if ($item['is_went'] == 0) {
        //   $class="strong";
        // }
    ?>

    <!-- メニュー -->
    <tr class="<?=$class?>">
      <!-- ポイント名 -->
      <td class="align-left">
        <a href="./detail.php"> <?= $item['point'] ?> </a>
      </td>

      <!-- 日付 -->
      <td class="align-left">
        <?=$item['date']?>
      </td>

      <!-- 登録者 -->
      <td>
        <?=$item['name']?>
      </td>

      <!-- 状態 -->
      <td>
        <?php
          if ($item['is_went'] == 0) {
            echo '気になる';
          } else {
            echo '行った';
          }
        ?>
      </td>

      <!-- 操作 -->
      <td>
        <form action="./trip.php" method="post">
          <input type="hidden" name="item_id" value="<?=$item['id']?>">
          <input type="submit" value="状態">
        </form>

        <form action="./edit.php" method="post">
          <input type="hidden" name="item_id" value="<?=$item['id']?>">
          <input type="submit" value="更新">
        </form>

        <form action="./delete.php" method="post">
          <input type="hidden" name="item_id" value="<?=$item['id']?>">
          <input type="submit" value="削除">
        </form>
      </td>

      <?php
        $line++;
        endforeach;
      ?>
    </table>

    <?php if ($isSearch): ?>
      <div class="main-footer">
      <form>
        <div class="goback">
          <input type="button" value="戻る" onclick="location.href='./';">
        </div>
      </form>
    </div>
    <?php endif ?>
  </main>

  <footer>

  </footer>

</div>
</body>
</html>