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
  if (empty($_SESSION['user'])) {
    // 未ログインのとき
    header('Location: ../');
  } else {
    // ログイン済みのとき
    $user = $_SESSION['user'];
  }

  // サニタイズ
  $get = CommonUtil::sanitaize($_GET);

  try {
    $items = array();
    // 指定IDの作業項目を取得
    $db = new TripItemsModel();
    $items = $db->getTripItemById($get['id']);
 
  } catch (Exception $e) {
    // var_dump($e);
    header('Location: ../error.php');
  }

  $str_went = '';
  if ($items['is_went'] == 0 ) {
    $str_went = '気になる';
  } else {
    $str_went = '行った';
  }

  // ページタイトル
  $title = '詳細ページ';
?>

<!DOCTYPE html>
<html lang="jp">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title> <?= $title ?> </title>
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/bootstrap.css">
  <link rel="stylesheet" href="../css/main.css">
</head>

<body>
<div class="container">
  <!-- body-header -->
  <?php require_once ($root."/trip/header.php"); ?>


  <!-- body-main -->
  <main>
    <?php if (!empty($_SESSION['msg']['error'])): ?>
      <p class="error">
        <?=$_SESSION['msg']['error']?>
      </p>
    <?php endif ?>

      <table class="table mt-3">
        <tr>
          <th scope="row">日時</th>
          <td class="align-l">
            <?= $items['date'] ?>
          </td>
        </tr>
        <tr>
          <th scope="row">ポイント</th>
          <td class="align-l">
            <?= $items['point'] ?>
          </td>
        </tr>
        <tr>
          <th scope="row">地域</th>
          <td class="align-l">
            <?= $items['area'] ?>
          </td>
        </tr>
        <tr>
          <th scope="row">状態</th>
         <td class="align-l">
           <?= $str_went ?>
        </td>
          </td>
        </tr>
        <tr>
          <th scope="row">マップ</th>
          <td class="align-l ggmap">
            <?= $items['map_item'] ?>
          </td>
        </tr>
        <tr>
          <th scope="row">備考</th>
          <td class="align-l">
            <?= $items['comment'] ?>
          </td>
        </tr>
      </table>

      <!-- ※ボタン -->
      <div class="mb-5">
        <input type="button" value="戻る" onclick="location.href='./';" class="btn btn-outline-primary">
      </div>
    </form>
  </main>

  <footer>
  </footer>
</div>
</body>
</html>