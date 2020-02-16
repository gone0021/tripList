<?php
  // クラスの読み込み
  $root = $_SERVER["DOCUMENT_ROOT"];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");
  require_once($root."/classes/util/CommonUtil.php");
  require_once($root."/classes/model/UsersModel.php");

  // セッションスタート
  SessionUtil::sessionStart();

  // サニタイズ
  $post = CommonUtil::sanitaize($_POST);

  try {
    // ユーザーの検索とユーザー情報の取得
    $db = new UsersModel();
    // 入力フォームで入力されたemailとpasswordをgetUserの引数にpost
    $user = $db->checkPassForEmail($post["email"], $post["password"]);

    if (empty($user)) {
      // ※ユーザーの情報が取得できなかったとき
      // エラーメッセージをSESSIONに保存
      $_SESSION["msg"]["error"] = "情報が一致しません";

      // POSTされてきたメールアドレスをSESSIONに保存
      $_SESSION["post"]["email"] = $post["email"];

      // ログインページへリダイレクト
      header("Location: ./");
    } else {
      // ※ユーザー情報が取得できたとき
      // ユーザー情報をSESSIONに保存
      $_SESSION["user"] = $user;

      // SESSIONに保存されているエラーメッセージをクリア
      $_SESSION["msg"]["error"] = "";
      unset($_SESSION["msg"]["error"]);

      // SESSIONに保存されているPOSTされてきたデータをクリア
      $_SESSION["post"] = "";
      unset($_SESSION["post"]);

      // 作業一覧ページを表示
      header("Location: ./trip/");
    }

  } catch (Exception $e) {
    // var_dump($e);exit;
    header("Location: ./error.php");
  }