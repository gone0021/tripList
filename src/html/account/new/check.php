<?php
  $root = $_SERVER["DOCUMENT_ROOT"];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");
  require_once($root."/classes/util/CommonUtil.php");
  require_once($root."/classes/util/ValidationUtil.php");
  require_once($root."/classes/model/UsersModel.php");

  SessionUtil::sessionStart();
  $userModel = new UsersModel();

  // フォームで送信されてきたトークンが正しいかどうか確認（CSRF対策）
  if (!isset($_SESSION['token']) || $_SESSION['token'] !== $_POST['token']) {
    $_SESSION['err_msg']['err'] = "不正な処理が行われました。";
    header('Location: ./');
    exit;
  }

  // サニタイズ
  $post = CommonUtil::sanitaize($_POST);

  // POSTされてきた値をセッションに代入
  $_SESSION['post'] = $post;

  // バリデーションチェック
  $validityCheck = array();

  // 名前のバリデーション
  $validityCheck[] = validationUtil::isValidName (
    $post['name'], $_SESSION['err_msg']['name']
  );

  // ユーザーネームの重複チェック
  $nameCheck = $userModel->getUserNmae($post['name']);
  if (!empty($nameCheck)) {
    $validityCheck[] = false;
    $_SESSION["err_msg"]["name"] = "既に使われています";
  } else {
    $validityCheck[] = true;
  }

  // メールアドレスのバリデーション
  $validityCheck[] = validationUtil::isValidEmail (
    $post['email'], $_SESSION['err_msg']['email']
  );

  // メールアドレスの重複チェック
  $emailCheck = $userModel->getUserEmail($post['email']);
  if (!empty($emailCheck)) {
    $validityCheck[] = false;
    $_SESSION["err_msg"]["email"] = "メールアドレスが重複しています";
  } else {
    $validityCheck[] = true;
  }

  // 名前のバリデーション
  $validityCheck[] = validationUtil::isDate (
    $post['birthday'], $_SESSION['err_msg']['birthday']
  );

  // メールアドレスのバリデーション
  $validityCheck[] = validationUtil::isValidPass (
    $post['pass1'], $_SESSION['err_msg']['pass1']
  );

  // ダブルチェック
  $validityCheck[] = validationUtil::isDoubleCheck (
    $post['pass1'], $post['pass2'], $_SESSION['err_msg']['pass2']
  );

  // バリデーションで不備があった場合
  foreach ($validityCheck as $k => $v) {
    // $vにnullが代入されている可能性があるので「===」で比較
    if ($v === false) {
      header('Location: ./');
      exit;
    }
  }

  // エラーメッセージをクリア
  unset($_SESSION['err_msg']);
  $_SESSION['err_msg'] = null;

 var_dump($post['name']);
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>登録内容の確認</title>
  <link rel="stylesheet" href="../../css/normalize.css">
  <link rel="stylesheet" href="../../css/main.css">
</head>

<body>
  <div class="container">
    <header>
      <h1 id="head-l">登録内容の確認</h1>
    </header>

    <form action="./add.php" method="post">
      <table class="login">
        <p>
          下記でよろしければ「送信」ボタンを押してください。
        </p>

        <tr>
        <th>お名前</th>
          <td>
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
            <?= ($post['pass2']) ?>
            <input type="hidden" name="pass2" value="<?=$post['pass2']?>">
          </td>
        </tr>
      </table>
      <input type="submit" value="送信" id="add">
      <input type="button" value="戻る" onclick="location.href='./';">
    </form>
  </main>

  <footer>
  </footer>
</div>
</body>
</html>