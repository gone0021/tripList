<?php
  $root = $_SERVER["DOCUMENT_ROOT"];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");
  require_once($root."/classes/util/CommonUtil.php");
  require_once($root."/classes/util/ValidationUtil.php");
  require_once($root."/classes/model/UsersModel.php");

  // セッションスタート
  SessionUtil::sessionStart();

  // フォームで送信されてきたトークンが正しいかどうか確認（CSRF対策）
  if (!isset($_SESSION['token']) || $_SESSION['token'] !== $_POST['token']) {
    $_SESSION['msg']['err'] = "不正な処理が行われました。";
    header('Location: ./');
    exit;
  }

  // サニタイズ
  $post = CommonUtil::sanitaize($_POST);

  // POSTされてきた値をSESSIONに代入（入力画面で再表示）
  $_SESSION['post'] = $post;

  // ユーザークラスのインスタンス
  $userModel = new UsersModel();

  // バリデーションチェック
  $validityCheck = array();
  // 名前のバリデーション
  $validityCheck[] = validationUtil::isValidName (
    $post['name'], $_SESSION['msg']['name']
  );
  // メールアドレスのバリデーション
  $validityCheck[] = validationUtil::isValidEmail (
    $post['email'], $_SESSION['msg']['email']
  );
  // ユーザーネームの重複チェック
  $checkName = $userModel->getUserForNmae($post['name']);
  if (!empty($checkName)) {
    $validityCheck[] = false;
    $_SESSION["msg"]["name"] = "既に使われています";
  } else {
    $validityCheck[] = true;
  }
  // メールアドレスの重複チェック
  $checkEmail = $userModel->getUserForEmail($post['email']);
  if (!empty($checkEmail)) {
    $validityCheck[] = false;
    $_SESSION["msg"]["email"] = "メールアドレスが重複しています";
  } else {
    $validityCheck[] = true;
  }
  // 誕生日のバリデーション
  $validityCheck[] = validationUtil::isBirthday (
    $post['birthday'], $_SESSION['msg']['birthday']
  );
  // メールアドレスのバリデーション
  $validityCheck[] = validationUtil::isValidPass (
    $post['pass1'], $_SESSION['msg']['pass1']
  );
  // ダブルチェック
  $validityCheck[] = validationUtil::isDoubleCheck (
    $post['pass1'], $post['pass2'], $_SESSION['msg']['pass2']
  );

  // バリデーションで不備があった場合
  foreach ($validityCheck as $k => $v) {
    // $vにnullが代入されている可能性があるので「===」で比較
    if ($v === false) {
      header('Location: ./');
      exit;
    }
  }
 
  // パスワードの暗号化
  $hash = password_hash($post['pass2'], PASSWORD_DEFAULT);
 
  // パスワードを伏せ字に
  $hide = str_repeat('*', strlen($post["pass2"]));
  // $hide = $post["pass2"];

  // エラーメッセージをクリア
  unset($_SESSION['msg']);
  $_SESSION['msg'] = null;

//  var_dump($hide);
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>登録内容の確認</title>
  <link rel="stylesheet" href="../../css/bootstrap.css">
  <link rel="stylesheet" href="../../css/normalize.css">
  <link rel="stylesheet" href="../../css/main.css">
</head>

<body>
  <div class="container">
    <header>
      <h1 id="head-l">登録内容の確認</h1>
    </header>

    <!-- 送信フォーム -->
    <form action="./add.php" method="post">
      <table class="table">
        <p>
          下記でよろしければ「送信」ボタンを押してください。
        </p>

        <tr>
        <th class="">ユーザー名</th>
          <td class="">
            <?= $post['name'] ?>
            <input type="hidden" name="name" value="<?=$post['name']?>">
          </td>
        </tr>

        <tr>
          <th>メールアドレス</th>
          <td>
            <?= $post['email'] ?>
            <input type="hidden" name="email" value="<?=$post['email']?>">
          </td>
        </tr>

        <tr>
          <th>誕生日</th>
          <td>
            <?= $post['birthday'] ?>
            <input type="hidden" name="birthday" value="<?=$post['birthday']?>">
          </td>
        </tr>

        <tr>
          <th>パスワード</th>
          <td>
            <?= $hide ?>
            <input type="hidden" name="pass2" value="<?= $hash ?>">
          </td>
        </tr>
      </table>

      <!-- ※ボタン -->
      <div class="my-2 text-center">
        <input type="submit" value="送信" class="btn btn-primary">
        <input type="button" value="戻る" class="btn btn-outline-primary" onclick="location.href='./';">
      </div>

    </form>

  </main>

  <footer>
  </footer>
</div>
</body>
</html>