<?php
  // require_once($_SERVER["DOCUMENT_ROOT"]."/classes/util/SessionUtil.php");
  $root = $_SERVER["DOCUMENT_ROOT"];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");

  // セッションスタート
  SessionUtil::sessionStart();

  // セッション変数もクリア
  $_SESSION["search"] = "";
  unset($_SESSION["search"]);

  // ログインページへリダイレクト
  header("Location: ./");
