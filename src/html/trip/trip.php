<?php
  $root = $_SERVER['DOCUMENT_ROOT'];
  $root .= "/data/tripList/html";
  require_once($root."/classes/util/SessionUtil.php");
  require_once($root."/classes/util/CommonUtil.php");
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

  // サニタイズ
  $post = CommonUtil::sanitaize($_POST);


  try {
    $item = array();
    $db = new TripItemsModel();
    $item = $db->getTripItemById($post['item_id']);

    if ($item['is_went'] == 0) {
      $db->updateToWant($post['item_id']);
      header('Location: ./');
    } else {
      $db->updateToWent($post['item_id']);
      header('Location: ./');
    }

  } catch (Exception $e) {
    // var_dump($e);exit;
    header('Location: ../error/error.php');
  }
