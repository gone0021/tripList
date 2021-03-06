<?php
  // require_once($_SERVER["DOCUMENT_ROOT"]."/classes/util/SessionUtil.php");
  $root = $_SERVER["DOCUMENT_ROOT"];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");

  // セッションスタート
  SessionUtil::sessionStart();

  // ログインユーザー情報をクリアしてログアウト処理とする
  $_SESSION["user"] = "";
  unset($_SESSION["user"]);

  // 念のために他のセッション変数もクリア
  $_SESSION["post"] = "";
  unset($_SESSION["post"]);
  $_SESSION["msg"] = "";
  unset($_SESSION["msg"]);
  $_SESSION["search"] = "";
  unset($_SESSION["search"]);

  // ログインページへリダイレクト
  header("Location: ./");
