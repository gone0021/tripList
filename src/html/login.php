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
      // ユーザーの情報が取得できなかったとき
      // エラーメッセージをセッション変数に保存 → ログインページに表示
      $_SESSION["msg"]["error"] = "情報が一致しません";

      // POSTされてきたメールアドレスをセッション変数に保存→ログインページのメールアドレスのテキストボックスに表示
      $_SESSION["post"]["email"] = $post["email"];
      $_SESSION["post"]["password"] = $post["password"];

      // ログインページへリダイレクト
      header("Location: ./");
    } else {
      // メールアドレスの情報が取得できたとき
      // ユーザー情報をセッション変数に保存（メニューで表示するためnameを保存する）
      $_SESSION["user"] = $user;

      // セッション変数に保存されているエラーメッセージをクリア
      $_SESSION["msg"]["error"] = "";
      unset($_SESSION["msg"]["error"]);

      // セッション変数に保存されているPOSTされてきたデータをクリア
      $_SESSION["post"] = "";
      unset($_SESSION["post"]);

      // 作業一覧ページを表示
      header("Location: ./trip/");
    }

  } catch (Exception $e) {
    // var_dump($e);exit;
    header("Location: ./error.php");
  }