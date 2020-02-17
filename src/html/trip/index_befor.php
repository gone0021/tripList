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

  // ※ログインの確認
  // $_SESSION['user']：ログイン時に取得したユーザー情報
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

    // searchに値があればsearchで検索
    if (isset($_GET['search'])) {
      // GETに項目があるときは検索
      $_SESSION['search'] = $_GET['search'];
      $search = $_GET['search'];
      $isSearch = true;
      $items = $db->getTripItemBySearch($search);
    } else if (isset($_SESSION['search'])) {
      // SESSIONに項目がある時はSESSIONの項目で検索
      $search =  $_SESSION['search'];
      $isSearch = true;
      $items = $db->getTripItemBySearch($search);
    } else {
      // GET・SESSIONに項目がないときは項目を全件取得
      $items = $db->getTripItemAll();
    }
  } catch (Exception $e) {
    // var_dump($e);
    header('Location: ./error.php');
  }

  // 奇数行(odd)・偶数行(even)の判定用カウンタ
  $line = 0;

  // var_dump($_SESSION['user']['id']);
?>

<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>リスト一覧</title>
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/main.css">
</head>

<body>
<div class="container">
  <!-- body-header -->
  <header class="">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <h2 class="navbar-brand mt-2">リスト一覧</h2>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <!-- Homeに戻る -->
          <li class="nav-item active">
            <a class="nav-link" href="./">Home <span class="sr-only">(current)</span></a>
          </li>

          <!-- 新規登録 -->
          <form action="./" method="get">
            <li class="nav-item">
              <a class="nav-link" href="./new.php">new</a>
            </li>
          </form>

          <!-- ドロップダウン -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <?=$user['name'] ?>さん
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <a class="dropdown-item" href="../logout.php">logout</a>
            </div>
          </li>
        </ul>

        <!-- 検索フォーム -->
        <form action="./" method="get" class="form-inline my-2 my-lg-0">
          <input type="search" name="search" id="search" class="form-control mr-sm-2" placeholder="Search" aria-label="Search">
          <input type="submit" value="🔍検索" class="btn btn-outline-primary">
        </form>

      </div>
    </nav>
  </header>

  <!-- body-main -->
  <main>
    <!-- タイトル -->
    <table class="table mt-3">
      <tr>
        <th scope="col" class="">ポイント名</th>
        <th scope="col" class="">日付</th>
        <th scope="col" class="">登録者</th>
        <th scope="col" class="">状態</th>
        <th scope="col" class="">操作</th>
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
          <form action="./trip.php" method="post" class="float-left">
            <?php if ($item['user_id'] === $user['id']): ?>
              <input type="hidden" name="item_id" value="<?=$item['id']?>">
              <input type="submit" value="状態" class="btn btn-outline-primary mr-2">
            <?php else: ?>
              <span >操作不可</span>
            <?php endif ?>
          </form>

          <form action="./edit.php" method="post" class="float-left">
            <?php if ($item['user_id'] === $user['id']): ?>
              <input type="hidden" name="item_id" value="<?=$item['id']?>">
              <input type="submit" value="更新" class="btn btn-outline-primary mr-2">
            <?php endif ?>
          </form>

          <form action="./delete.php" method="post" class="float-left">
            <?php if ($item['user_id'] === $user['id']): ?>
              <input type="hidden" name="item_id" value="<?=$item['id']?>">
              <input type="submit" value="削除" class="btn btn-outline-primary">
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
      <form>
        <div class="my-3">
          <input type="button" value="戻る" onclick="location.href='./back.php';" class="btn btn-outline-primary">
        </div>
      </form>
    <?php endif ?>
  </main>

  <footer>
  </footer>

</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>