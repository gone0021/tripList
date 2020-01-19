<?php
  $root = $_SERVER["DOCUMENT_ROOT"];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");
  require_once($root."/classes/util/CommonUtil.php");
  require_once($root."/classes/util/ValidationUtil.php");
  require_once($root."/classes/model/UsersModel.php");

  // セッションスタート
  SessionUtil::sessionStart();

  // サニタイズ
  $post = CommonUtil::sanitaize($_POST);

  // バリデーションチェック
  $validityCheck = array();

  // メールアドレスのバリデーション
  $validityCheck[] = validationUtil::isValidEmail (
    $post['email1'], $_SESSION['msg']['email1']
  );

  // ダブルチェック
  $validityCheck[] = validationUtil::isDoubleCheck (
    $post['email1'], $post['email2'], $_SESSION['msg']['email2'] 
  );

  // 誕生日のバリデーション
  $validityCheck[] = validationUtil::isDate (
    $post['birthday'], $_SESSION['msg']['birthday']
  );

  // バリデーションで不備があった場合
  foreach ($validityCheck as $k => $v) {
    // $vにnullが代入されている可能性があるので「===」で比較
    if ($v === false) {
      // POSTされてきたメールアドレスをセッション変数に保存→ログインページのメールアドレスのテキストボックスに表示
      $_SESSION["post"]["email1"] = $post["email1"];
      $_SESSION["post"]["email2"] = $post["email2"];
      $_SESSION["post"]["birthday"] = $post["birthday"];
      header('Location: ./');
      exit;
    }
  }

  // バリデーションを通過
  try {
    // ユーザーの検索とユーザー情報の取得
    $db = new UsersModel();
    // 入力フォームで入力されたemailとpasswordをgetUserの引数にpost
    $user = $db->checkBirthdayForEmail($post["email2"], $post["birthday"]);

    if (empty($user)) {
      // ユーザーの情報が取得できなかったとき
      // エラーメッセージをセッション変数に保存 → ログインページに表示
      $_SESSION["msg"]["error"] = "情報が一致しません";

      // POSTされてきたデータをセッションに保存→ログインページのメールアドレスのテキストボックスに表示
      $_SESSION["post"]["email1"] = $post["email1"];
      $_SESSION["post"]["email2"] = $post["email2"];
      $_SESSION["post"]["birthday"] = $post["birthday"];

      // ログインページへリダイレクト
      header("Location: ./");

    } else {
      // メールアドレスの情報が取得できたとき
      // セッション変数に保存されているエラーメッセージをクリア
      $_SESSION["msg"]["error"] = "";
      unset($_SESSION["msg"]["error"]);

      // セッション変数に保存されているPOSTされてきたデータをクリア
      $_SESSION["post"] = "";
      unset($_SESSION["post"]);

      // POSTされてきたメールをセッションに保存→updateのwhereに使用
      $_SESSION["email2"] = $post["email2"];

      // // 作業一覧ページを表示
      header('Location: ./update.php');
    }
  } catch (Exception $e) {
    // var_dump($e);exit;
    header("Location: ../../error.php");
  }
