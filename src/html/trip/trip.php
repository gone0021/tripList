<?php
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");
  require_once($root."/classes/model/TripItemsModel.php");

  // セッションスタート
  SessionUtil::sessionStart();

  if (empty($_SESSION['user'])) {
    // 未ログインのとき
    header('Location: ../login/');
  } else {
    // ログイン済みのとき
    $user = $_SESSION['user'];
  }

  $_SESSION['search'] = $is_search;

  if (!empty($_SESSION['search'])) {
    $back = header("Location: ../error.php/?seach=$is_search");
  } else {
    $back = header('Location: ../error.php');
  }

  try {
    $item = array();
    $db = new TripItemsModel();
    $item = $db->getTripItemById($_POST['item_id']);

    if ($item['is_went'] == 0) {
      $db->updateToWant($_POST['item_id']);
      header('Location: ./');
    } else {
      $db->updateToWent($_POST['item_id']);
      header('Location: ./');
    }

  } catch (Exception $e) {
    // var_dump($e);exit;
    header('Location: ../error.php');
  }
