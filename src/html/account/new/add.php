<?php
  $root = $_SERVER["DOCUMENT_ROOT"];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");
  require_once($root."/classes/util/CommonUtil.php");
  require_once($root."/classes/util/ValidationUtil.php");
  require_once($root."/classes/model/UsersModel.php");

  SessionUtil::sessionStart();

  // サニタイズ
  $post = CommonUtil::sanitaize($_POST);

  // データベースに登録する内容を連想配列にする。
  $data = array (
    'name' => $post['name'],
    'email' => $post['email'],
    'birthday' => $post['birthday'],
    'password' => $post['pass2'],
  );

  // var_dump($post['name']); exit;

  try {
    $db = new UsersModel();
    $db->insertUser($data);

  } catch (Exception $e) {
    // var_dump($e);exit;
    header('Location: ../../error.php');
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>登録完了</title>
  <link rel="stylesheet" href="../../css/normalize.css">
  <link rel="stylesheet" href="../../css/main.css">
</head>

<body>
  <div class="container">
  <header>
      <h1 id="head-l">登録完了</h1>
  </header>

  <main>
    <table>
      <tr>
        <th>登録が完了しました</th>
      </tr>

      <tr>
        <td>
          <a href="../../">ログイン画面へ</a>
        </td>
      </tr>
    </table>
  </main>

  <footer>
  </footer>
</div>
</body>
</html>