<?php
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");
  require_once($root."/classes/util/CommonUtil.php");
  require_once($root."/classes/util/ValidationUtil.php");

  // セッションスタート
  SessionUtil::sessionStart();

  // ログインの確認
  // $user = $db->checkPassForEmail($post["email"], $post["password"]); メールアドレスとパスワードからユーザー情報を検索
  if (empty($_SESSION['name'])) {
    // 未ログインのとき
    header('Location: ../login/');
  } else {
    // ログイン済みのとき
    $user = $_SESSION['name'];
  }

  // フォームで送信されてきたトークンが正しいかどうか確認（CSRF対策）
  // if (!isset($_SESSION['token']) || $_SESSION['token'] !== $_POST['token']) {
  //   $_SESSION['msg']['err'] = "不正な処理が行われました。";
  //   header('Location: ./new.php');
  //   exit;
  // }

  // サニタイズ
  $post = CommonUtil::sanitaize($_POST);

  // POSTされてきた値をセッションに代入
  $_SESSION['post'] = $post;

  // バリデーションチェック
  $validityCheck = array();
  // 日付
  $validityCheck[] = validationUtil::isDate (
    $post['date'], $_SESSION['msg']['date']
  );
  // 地域名
  $validityCheck[] = validationUtil::isValidItem (
    $post['area'], $_SESSION['msg']['area']
  );
  // ポイント名
  $validityCheck[] = validationUtil::isValidItem (
    $post['point'], $_SESSION['msg']['point']
  );
  // マップ
  $validityCheck[] = validationUtil::isValidMap (
    $post['map_item'], $_SESSION['msg']['map_item']
  );
  // 備考
  $validityCheck[] = validationUtil::isValidComment (
    $post['comment'], $_SESSION['msg']['comment']
  );
  // バリデーションで不備があった場合
  foreach ($validityCheck as $k => $v) {
    // $vにnullが代入されている可能性があるので「===」で比較
    if ($v === false) {
      header('Location: ./new.php');
      exit;
    }
  }

  // バリデーションを通過したらセッションに保存したエラーメッセージをクリア
  $_SESSION['msg']['error'] = '';

  $is_went = '';
  if ($post['is_went'] == 0 ) {
    $is_went = '気になる';
  } else {
    $is_went = '行った';
  }


  // if (preg_match("/<iframe src=\"https:\/\/www\.google\.com\/maps(.*?)<\/iframe>/s", $post['map'])) {
  if (preg_match("/&lt;iframe src=\&quot;https:\/\/www.google\.com\/maps(.*?)&lt;\/iframe&gt;/s",$post['map_item'])) {
    $mach = 'yes';
  } else {
    $mach = 'no';
  }

  // var_dump($post['map_item']);
  // echo "<br>";
  // var_dump($mach);
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>新規登録</title>
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="container">
  <header>
      <div class="title">
        <h1>新規登録</h1>
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
    <?php if (!empty($_SESSION['msg']['error'])): ?>
        <p class="error">
            <?=$_SESSION['msg']['error']?>
        </p>
    <?php endif ?>
  
    <!-- POST_FORM -->
    <form action="./new_add.php" method="post">
      <table class="list">
        <tr>
          <th>日時</th>
          <td class="align-l">
            <?= $post['date'] ?>
            <input type="hidden" name="date" id="date" class="date" value="<?= $post['date'] ?>">
          </td>
        </tr>
        <tr>
          <th>ポイント</th>
          <td class="align-l">
            <?= $post['point'] ?>
            <input type="hidden" name="point" id="point" class="item_name" value="<?= $post['point'] ?>">
          </td>
        </tr>
        <tr>
          <th>地域</th>
          <td class="align-l">
            <?= $post['area'] ?>
            <input type="hidden" name="area" id="area" class="item_name" value="<?= $post['area'] ?>">
          </td>
        </tr>
        <tr>
          <th>状態</th>
         <td class="align-l">
           <?= $is_went ?>
          <input type="hidden" name="is_went" value=<?= $post['is_went'] ?>>
        </td>
          </td>
        </tr>
        <tr>
          <th>マップ</th>
          <td class="align-l ggmap">
            <?= $post['map_item'] ?>
            <input type="hidden"  name="map_item" id="map_item" class="item_name" value="<?= $post['map_item'] ?>">
          </td>
        </tr>
        <tr>
          <th>備考</th>
          <td class="align-l">
            <?= $post['comment'] ?>
            <input type="hidden"  name="comment" id="comment" class="item_name" value="<?= $post['comment'] ?>">
          </td>
        </tr>
      </table>

      <span class="mrg-r20">
        <input type="submit" value="登録">
      </span>
      <input type="button" value="戻る" onclick="location.href='./new.php';">
      <br><br>
    </form>
  </main>

  <footer>

  </footer>
  <?php
    unset($_SESSION['msg']); 
    // var_dump($user);
  ?>
</div>
</body>
</html>