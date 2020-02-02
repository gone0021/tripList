<?php
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");
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

  try {
    $item = array();
    // 指定IDの作業項目を取得
    $db = new TripItemsModel();
    $item = $db->getTripItemById($_GET['id']);
 
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

  // var_dump($_GET['id'] );

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
            <input type="button" value="ログアウト" onclick="location.href='../logout.php';">
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

      <table class="list">
        <tr>
          <th>日時</th>
          <td class="align-l">
            <?= $item['date'] ?>
          </td>
        </tr>
        <tr>
          <th>ポイント</th>
          <td class="align-l">
            <?= $item['point'] ?>
          </td>
        </tr>
        <tr>
          <th>地域</th>
          <td class="align-l">
            <?= $item['area'] ?>
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
            <?= $item['map_item'] ?>
          </td>
        </tr>
        <tr>
          <th>備考</th>
          <td class="align-l">
            <?= $item['comment'] ?>
          </td>
        </tr>
      </table>

      <input type="button" value="戻る" onclick="location.href='./';">
      <br><br>

    </form>
  </main>

  <footer>
  </footer>
</div>
</body>
</html>