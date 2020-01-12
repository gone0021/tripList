<?php
  // サニタイジング
  $post = array();
  foreach ($_POST as $k => $v) {
    $post[$k] = htmlspecialchars($v, ENT_QUOTES, "UTF-8");
    // $post[$k] = $v;
  }

  try {
    // DBへ接続
    $dsn = "mysql:host=localhost; dbname=todo_list; charset=utf8";
    $user = "root";
    $password = "";
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // POSTデータをデータベースにインサートするセッティング
    $sql = "INSERT INTO todo_items ("; // ※insert 
    $sql .= "expiration_date, ";
    $sql .= "todo_item";
    $sql .= ") " ;
    $sql .= "Values ("; // ※value
    $sql .= ":expiration_date, ";
    $sql .= ":todo_item";
    $sql .= ")";

    // セッティング情報をSQL文にセット
    $stmt = $dbh->prepare($sql);
    // 期限日とtodo項目をpostする
    $stmt->bindValue(":expiration_date", $post["expiration_date"], PDO::PARAM_STR);
    $stmt->bindValue(":todo_item", $post["todo_item"], PDO::PARAM_STR);
    // SQL文の実行
    $stmt->execute();

    // 処理が完了したらトップページへリダイレクト
    header("Location: ./");

  } catch (Exception $e) {
    var_dump($stmt);
    exit;
  }
?>