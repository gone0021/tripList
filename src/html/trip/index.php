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
  if (empty($_SESSION['user'])) {
    // 未ログインのとき
    header('Location: ../');
  } else {
    // ログイン済みのとき
    $user = $_SESSION['user'];
  }

  // 検索キーワード
  if (isset($_SESSION['search'])) {
    $search = $_SESSION['search'];
  } else {
    $search = '';
  }

  try {
    // 通常の一覧表示か、検索結果かを保存するフラグ
    $isSearch = false;
    $db = new TripItemsModel();

    // searchに値があればsearchで検索する
    if (isset($_GET['search'])) {
      // GETに項目があるときは検索
      $_SESSION['search'] = $_GET['search'];
      $search = $_GET['search'];
      $isSearch = true;
      $items = $db->getTripItemBySearch($search);
    } else if (isset($_SESSION['search'])) {
      $search =  $_SESSION['search'];
      $isSearch = true;
      $items = $db->getTripItemBySearch($search);
    } else {
      // GETに項目がないときは、作業項目を全件取得
      $items = $db->getTripItemAll();
    }
  } catch (Exception $e) {
    // var_dump($e);
    header('Location: ./error.php');
  }

  // var_dump($_SESSION['user']['id']);

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
        <!-- 新規登録 -->
        <div class="entry">
          <input type="button" name="new" id="new" class="new" value="作業登録" onclick="location.href='./new.php'">
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
        // go to endforeach
      ?>

      <!-- メニュー -->
      <tr class="<?=$class?>">
        <!-- ポイント名 -->
        <td class="align-left">
          <a href="./detail.php?id=<?= $item['id'] ?>"> <?= $item['point'] ?> </a>
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
            <?php if ($item['user_id'] === $user['id']): ?>
              <input type="hidden" name="item_id" value="<?=$item['id']?>">
              <input type="submit" value="状態">
            <?php else: ?>
              <span>操作不可</span>
            <?php endif ?>
          </form>

          <form action="./edit.php" method="post">
            <?php if ($item['user_id'] === $user['id']): ?>
              <input type="hidden" name="item_id" value="<?=$item['id']?>">
              <input type="submit" value="更新">
            <?php endif ?>
          </form>

          <form action="./delete.php" method="post">
            <?php if ($item['user_id'] === $user['id']): ?>
              <input type="hidden" name="item_id" value="<?=$item['id']?>">
              <input type="submit" value="削除">
            <?php endif ?>
          </form>
        </td>

        <?php
          $line++;
          endforeach; // 行数チェックのforeach
        ?>
      </tr>
    </table>

    <?php if ($isSearch): ?>
      <div class="main-footer">
        <form>
          <div class="goback">
            <input type="button" value="戻る" onclick="location.href='./back.php';">
          </div>
        </form>

        <!-- <form action="./back.php">
          <div class="goback">
            <input type="submit" value="戻る" onclick="location.href='./';">
          </div>
        </form> -->
      </div>
    <?php endif ?>
  </main>

  <footer>

  </footer>

</div>
</body>
</html>