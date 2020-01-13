<?php
  // POSTデータがないときは、トッページにリダイレクト
  if (empty($_POST)) {
    header("Location: ./");
  }

  try {
    // DBへ接続
    $dsn = "mysql:host=localhost; dbname=todo_list; charset=utf8";
    $user = "root";
    $password = "";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 完了の処理のセッティング
    foreach ($_POST["is_completed"] as $k => $v) {
      $sql = " UPDATE todo_items set "; // ※update
      $sql .= "is_completed = :value ";
      $sql .= "Where id = :id";

      // セッティング情報をSQL文にセット
      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(":id", $k, PDO::PARAM_INT);
      $stmt->bindValue(":value", $v, PDO::PARAM_INT);
      // SQL文の実行
      $stmt->execute();
    }

    // 削除解除の処理
    foreach ($_POST["is_deleted"] as $k => $v) {
      if ($v != "on") {
          continue;
      }

      $sql = "";
      $sql .= "UPDATE todo_items set "; // ※update
      $sql .= "is_deleted = 0 ";
      $sql .= "Where id = :id";

      $stmt = $dbh->prepare($sql);
      $stmt->bindValue(":id", $k, PDO::PARAM_INT);
      $stmt->execute();
    }

    // var_dump($stmt);

    // 処理が完了したら、トップページへリダイレクト
    header("Location: ./");

  } catch (Exception $e) {
    var_dump($e);
    exit;
  }

?>