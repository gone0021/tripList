<?php
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");
  require_once($root."/classes/util/CommonUtil.php");
  require_once($root."/classes/util/ValidationUtil.php");

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

  // フォームで送信されてきたトークンが正しいかどうか確認（CSRF対策）
  if (!isset($_SESSION['token']) || $_SESSION['token'] !== $_POST['token']) {
    $_SESSION['msg']['err'] = "不正な処理が行われました。";
    header('Location: ./edit.php');
    exit;
  }

  // サニタイズ
  $post = CommonUtil::sanitaize($_POST);

  // POSTされてきた値をSESSIONに代入（入力画面で再表示）
  $_SESSION['post'] = $post;

  // バリデーションチェック
  $validityCheck = array();
  // 日付
  $validityCheck[] = validationUtil::isDate (
    $post['date'], $_SESSION['msg']['date']
  );
  // ポイント名
  $validityCheck[] = validationUtil::isValidItem (
    $post['point'], $_SESSION['msg']['point']
  );
  // 地域名
  $validityCheck[] = validationUtil::isValidItem (
    $post['area'], $_SESSION['msg']['area']
  );
  // マップ
  $validityCheck[] = validationUtil::isValidMap (
    $post['map_item'], $_SESSION['msg']['map_item']
  );
  // 備考
  $validityCheck[] = validationUtil::isValidComment (
    $post['comment'], $_SESSION['msg']['comment']
  );
  // バリデーションで不備があった場合は登録ページへ戻る
  foreach ($validityCheck as $k => $v) {
    // $vにnullが代入されている可能性があるので「===」で比較
    if ($v === false) {
      header('Location: ./edit.php');
      exit;
    }
  }

  // バリデーションを通過したらSESSIONに保存したエラーメッセージをクリアする
  $_SESSION['msg']['error'] = '';

  // 気になる、行ったの文字列置き換え
  $str_went = '';
  if (isset($post['is_went']) && $post['is_went'] == 0 ) {
    $str_went = '気になる';
  } else {
    $str_went = '行った';
  }

  // map_itemのエンコード（iframeを直接入れるとダブルクオーテーションで途切れるため）
  $encode = '';
  $enc_map_item = base64_encode($post['map_item']);
  // $_SESSION['enc_map_item'] = $enc_map_item;
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>内容の更新</title>
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="container">
  <!-- body-header -->
  <header class="">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <h2 class="navbar-brand mt-2">内容の更新</h2>
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
    <?php if (!empty($_SESSION['msg']['error'])): ?>
        <p class="error">
            <?=$_SESSION['msg']['error']?>
        </p>
    <?php endif ?>
  
    <!-- 送信フォーム -->
    <form action="./edit_action.php" method="post">
      <table class="table mt-3">
        <!-- ※日時：date -->
        <tr>
          <th scope="row">日時</th>
          <td class="align-l">
            <?= $post['date'] ?>
            <input type="hidden" name="date" value="<?= $post['date'] ?>" id="date" class="date">
          </td>
        </tr>

        <!-- ※ポイント：point -->
        <tr>
          <th scope="row">ポイント</th>
          <td class="align-l">
            <?= $post['point'] ?>
            <input type="hidden" name="point" value="<?= $post['point'] ?>" id="point" class="item_name">
          </td>
        </tr>

        <!-- ※地域：area -->
        <tr>
          <th scope="row">地域</th>
          <td class="align-l">
            <?= $post['area'] ?>
            <input type="hidden" name="area" value="<?= $post['area'] ?>" id="area" class="item_name">
          </td>
        </tr>

        <!-- ※状態：is_went -->
        <tr>
          <th scope="row">状態</th>
          <td class="align-l">
            <?= $str_went ?>
            <input type="hidden" name="is_went" value=<?= $post['is_went'] ?>>
          </td>
        </tr>

        <!-- ※マップ：map -->
        <tr>
          <th scope="row">マップ</th>
          <td class="align-l ggmap">
            <?= $post['map_item'] ?>
            <input type="hidden"  name="map_item" class="item_name" value="<?= $enc_map_item ?>" id="map_item">
          </td>
        </tr>

        <!-- ※備考：comment -->
        <tr>
          <th scope="row">備考</th>
          <td class="align-l">
            <?= $post['comment'] ?>
            <input type="hidden"  name="comment" value="<?= $post['comment'] ?>" id="comment" class="item_name">
          </td>
        </tr>
      </table>

      <!-- ※ボタン -->
      <div class="mb-5">
        <span class="mr-3">
          <input type="submit" value="登録" class="btn btn-outline-primary">
        </span>
        <input type="button" value="戻る" onclick="location.href='./edit.php';" class="btn btn-outline-primary">
      </div>
    </form>
  </main>

  <footer>

  </footer>
  <?php
    unset($_SESSION['msg']); 
    // var_dump($user);
  ?>
</div>

<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>
</html>