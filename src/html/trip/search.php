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

  // dbへの接続
  try {
    $db = new TripItemsModel();
    // 検索キーワード
    $search = '';
    $get = CommonUtil::sanitaize($_GET);
    $search = $get['search'];
    $items = $db->getTripItemBySearch($search);
  } catch (Exception $e) {
    var_dump($e); exit;
    header('Location: ../error.php');
  }

  // is_wentの判定
  $is_went = '';
  if ($item['is_went'] == 0 ) {
    $is_went = '気になる';
  } else {
    $is_went = '行った';
  }

  // 奇数行(odd)・偶数行(even)の判定用カウンタ
  $line = 0;

  // var_dump($_GET['id']);
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
      <form action="./new.php" method="get">
        <!-- 新規登録ボタン -->
        <div class="entry">
          <input type="button" name="entry-button" id="entry-button" class="entry-button" value="作業登録" onclick="location.href='./new.php'">
        </div>
      </form>

      <!-- 検索フォーム -->
      <form action="./search.php" method="get">
        <div class="search">
          <input type="text" name="search" id="search">
          <input type="submit" value="🔍検索" onclick="location.href='./search.php'">
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
        // to endforeach
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
      </tr>
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