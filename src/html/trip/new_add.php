<?php
  $root = $_SERVER["DOCUMENT_ROOT"];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");
  require_once($root."/classes/util/CommonUtil.php");
  require_once($root."/classes/util/ValidationUtil.php");
  require_once($root."/classes/model/TripItemsModel.php");

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

  // サニタイズ
  $post = CommonUtil::sanitaize($_POST);

  // データベースに登録する内容を連想配列にする。
  $data = array (
    'user_id' => $user['id'],
    'area' => $post['area'],
    'point' => $post['point'],
    'date' => $post['date'],
    'is_went' => $post['is_went'],
    'map_item' => $post['map_item'],
    'comment' => $post['comment'],
  );

  try {
    $db = new TripItemsModel();
    $db->registerTripItem($data);

  } catch (Exception $e) {
    var_dump($e);exit;
    header('Location: ../error.php');
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
            <a href="./">メインページへ</a>
          </td>
        </tr>
      </table>
    </main>
  
    <footer>
    </footer>
    <?php
      unset($_SESSION['post']); 
      // var_dump($user);
    ?>
  </div>
  </body>
  </html>