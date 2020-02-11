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

  $is_went = '';
  if ($items['is_went'] == 0 ) {
    $is_went = '気になる';
  } else {
    $is_went = '行った';
  }
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
            <?= $items['date'] ?>
          </td>
        </tr>
        <tr>
          <th>ポイント</th>
          <td class="align-l">
            <?= $items['point'] ?>
          </td>
        </tr>
        <tr>
          <th>地域</th>
          <td class="align-l">
            <?= $items['area'] ?>
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
            <?= $items['map_item'] ?>

            <!-- iframeのフォーマット -->
            <!-- <p><iframe src="" name="map_item" ></iframe></p> -->

            <!-- iframeの例 -->
            <!-- <p><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13112.534326123272!2d135.5912386!3d34.7522277!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6000e1f7a3353209%3A0x3c271566781edba9!2z44K444Oj44Ks44O844Kw44Oq44O844Oz!5e0!3m2!1sja!2sjp!4v1581415320399!5m2!1sja!2sjp" name="example"> -->

            <!-- googlemapの地図埋め込み -->
            <!-- <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13112.534326123272!2d135.5912386!3d34.7522277!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6000e1f7a3353209%3A0x3c271566781edba9!2z44K444Oj44Ks44O844Kw44Oq44O844Oz!5e0!3m2!1sja!2sjp!4v1581416403748!5m2!1sja!2sjp" 
            width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="">
            </iframe> -->
            </iframe></p>
          </td>
        </tr>
        <tr>
          <th>備考</th>
          <td class="align-l">
            <?= $items['comment'] ?>
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