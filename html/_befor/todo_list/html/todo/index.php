<?php
  //日付の取得
  $date = new DateTime("Asia/Tokyo");
  $today = $date->format("Y-m-d");

  try {
    // DBへ接続
    $dsn = "mysql:host=localhost; dbname=todo_list; charset=utf8";
    $user = "root";
    $password = "";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 登録済みのTODOリストを呼び出すセッティング
    $sql = "SELECT "; // ※select
    $sql .= "id, "; // ID
    $sql .= "expiration_date, "; // 期限日
    $sql .= "todo_item, "; // todo項目
    $sql .= "is_completed "; // 完了フラグ, 0：未完了 , 1：完了,
    $sql .= "From "; // ※from
    $sql .= "todo_items "; //
    $sql .= "Where "; // ※where
    $sql .= "is_deleted = 0 "; // 削除フラグ, 0：未削除 , 1：削除済,
    $sql .= "order By expiration_date, id asc"; // ※order by

    // セッティング情報をSQL文にセット
    $stmt = $dbh->prepare($sql);
    // SQL文の実行
    $stmt->execute();
    // PDO::FETCH_ASSOC：列名を記述し配列で取り出す設定
    $list = $stmt->fetchAll();

    // var_dump($list);

  } catch (Exception $e) {
    var_dump($e);
    exit;
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <title>TODOリスト</title>
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/main.css">
</head>

<body>
<div class="container">
<h1>TODOリスト</h1>

<!-- TODO項目の追加 -->
<form action="add.php" method="post">
  <input type="date" name="expiration_date" value="<?= date("Y-m-d") ?>">
  <input type="text" name="todo_item" value="" class="item">
  <input type="submit" value="追加">
</form>

<!-- TODO項目の操作 -->
<?php if (count($list) > 0): ?>
<form action="action.php" method="POST">
  <table class="list">
    <tr>
      <th>期限日</th>
      <th>項目</th>
      <th>未完了</th>
      <th>完了</th>
      <th>削除</th>
    </tr>

    <!-- 項目の追加＋操作アクション -->
    <?php foreach ($list as $v): ?>
      <tr>
        <!-- 完了の場合 -->
        <?php if ($v["is_completed"] == 1): ?>
          <td class="del"><?= $v["expiration_date"] ?></td>
          <td class="del"><?= $v["todo_item"] ?></td>
        <!-- 完了でない場合 -->
        <?php else: ?>
          <td><?= $v["expiration_date"] ?></td>
          <td><?= $v["todo_item"] ?></td>
        <?php endif ?>

        <!-- ラジオボタンの設定 -->
          <td class="center"><input type="radio" name="is_completed[<?=$v["id"] ?>]" value="0"<?php if ($v["is_completed"] == 0) echo " checked" ?>></td>
          <td class="center"><input type="radio" name="is_completed[<?=$v["id"] ?>]" value="1"<?php if ($v["is_completed"] == 1) echo " checked" ?>></td>

          <!-- 削除ボックスの設定 -->
          <td class="center"><input type="checkbox" name="is_deleted[<?=$v["id"] ?>]"></td>
      </tr>
    <?php endforeach ?>
  </table>
  <input type="submit"  value="実行">
</form>
<?php endif ?>

<p><a href="../deleted">削除項目へ</a></p>

</div>
</body>
</html>