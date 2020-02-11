<?php
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");
  require_once($root."/classes/model/TripItemsModel.php");

	// セッションスタート
	SessionUtil::sessionStart();

	if (empty($_SESSION['name'])) {
		// 未ログインのとき
		header('Location: ../login/');
	} else {
		// ログイン済みのとき
		$user = $_SESSION['name'];
	}

	try {
		$db = new TripItemsModel();
		$db->deleteTripItemById($_SESSION['post']['item_id']);
		unset($_SESSION['post']);

	} catch (Exception $e) {
		// var_dump($e);
		header('Location: ../error.php');
	}
?>

  <!DOCTYPE html>
  <html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>削除完了</title>
    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" href="../../css/main.css">
  </head>
  
  <body>
    <div class="container">
    <header>
        <h1 id="head-l">削除完了</h1>
    </header>
  
    <main>
      <table>
        <tr>
          <th>削除が完了しました</th>
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
  </div>
  </body>
  </html>