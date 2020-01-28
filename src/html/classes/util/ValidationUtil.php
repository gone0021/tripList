<?php
/**
 * バリデーションユーティリティクラス
 */
class ValidationUtil {
  /**
   * ダブルチェックの妥当性を判定
   * @param string $item1 入力内容1
   * @param string $item2 入力内容2
   * @param string $msg エラーメッセージを代入
   * @return boolean
   */
  public static function isDoubleCheck($item1, $item2, &$msg): bool {
    $msg = '';
    if (empty($item2)) {
      $msg = "入力してください";
      return false;
    }
    if ($item1 != $item2) {
      $msg = "入力が一致しません";
      return false;
    }
    return true;
  }

  //+------------------------------------------------------------------+
  //| user check                                                       |
  //+------------------------------------------------------------------+
  /**
   * ユーザー名の妥当性をチェック
   * @param string $name 名前
   * @param string $msg エラーメッセージを代入
   * @return boolean
   */
  public static function isValidName($name, &$msg): bool {
    $msg = '';
    if (empty($name)) {
      $msg = "ユーザー名を入力してください";
      return false;
    }
    if (strlen($name) > 50) {
      $msg = "名前は50文字以内でご入力ください";
      return false;
    }
    return true;
  }

  /**
   * メールアドレスの妥当性をチェック
   * @param string $email メールアドレス
   * @param string $msg エラーメッセージを代入
   * @return boolean
   */
  public static function isValidEmail($email, &$msg): bool {
    $msg = '';
    if (empty($email)) {
      $msg = "メールアドレスを入力してください";
      return false;
    }
    if (!empty($email) && !preg_match('/^[0-9a-z_./?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$/', $email)) {
      $msg = "メールアドレスを正しく入力してください";
      return false;
    }
    if (strlen($email) > 256) {
      $msg = "メールアドレスは256文字以内で入力してください";
      return false;
    }
    return true;
  }

  /**
   * 正しい日付形式の文字列かどうかを判定
   * @param string $date 日付形式の文字列
   * @return boolean 正しいとき：true、正しくないとき：false
   */
  public static function isBirthday($date, &$msg): bool {
    // strtotime()関数を使って、タイムスタンプに変換できるかどうかで正しい日付かどうかを調べます。
    // https://www.php.net/manual/ja/function.strtotime.php
    // 参照
    $msg = '';
    if (empty($date)) {
      $msg = "誕生日を入力してください";
      return false;
    }
    
    if (!strtotime($date)) {
      $msg = "正しい日付を入力してください";
      return false;
    }
    return true;
  }

  /**
   * 名前の妥当性をチェック
   * @param string $pass パスワード
   * @param string $msg エラーメッセージを代入
   * @return boolean
   */
  public static function isValidPass($pass, &$msg): bool {
    $msg = '';
    if (empty($pass)) {
      $msg = "パスワードを入力してください";
      return false;
    }
    if (strlen($pass) < 8) {
      $msg = "8文字以上で入力してください";
      return false;
    }
    if (!empty($pass) && !preg_match('/(?=.*?[a-z])(?=.*?[0-9])[a-z0-9]/', $pass)) {
      $msg = "半角英数字を含めて入力してください";
    return false;
    }

    return true;
  }

  /**
   * 指定IDのユーザーが存在するかどうか判定
   * @param int $userId ユーザーID
   * @return boolean
   */
  public static function isValidUserId($userId) {
    // $userIdが数字でなかったら、falseを返却
    if (!is_numeric($userId)) {
      return false;
    }

    // $userIdが0以下はありえないので、falseを返却
    if ($userId <= 0) {
      return false;
    }

    // UserModelクラスのisExistUser()メソッドを使って、該当のユーザーを検索した結果を返却
    $root = $_SERVER['DOCUMENT_ROOT'];
    $root .= '/data/tripList/html';
    require_once($root.'/classes/model/BaseModel.php');
    $db = new UsersModel();
    return $db->isExistsUser($userId);
  }

  //+------------------------------------------------------------------+
  //| item check                                                       |
  //+------------------------------------------------------------------+
  /**
   * 正しい日付形式の文字列かどうかを判定
   * @param string $date 日付形式の文字列
   * @return boolean 正しいとき：true、正しくないとき：false
   */
  public static function isDate($date, &$msg): bool {
    $msg = '';
    if (empty($date)) {
      $msg = "日付を入力してください";
      return false;
    }
    
    if (!strtotime($date)) {
      $msg = "正しい日付を入力してください";
      return false;
    }
    return true;
  }

   /**
   * item名の妥当性をチェック
   * @param string $item item名
   * @param string $msg エラーメッセージを代入
   * @return boolean
   */
  public static function isValidItem($item, &$msg): bool {
    $msg = '';
    if (empty($item)) {
      $msg = "255文字以内で入力してください";
      return false;
    }
    if (strlen($item) > 255) {
      $msg = "255文字以内でご入力ください";
      return false;
    }
    return true;
  }

   /**
   * マップ名の妥当性をチェック
   * @param string $map map名
   * @param string $msg エラーメッセージを代入
   * @return boolean
   */
  public static function isValidMap($map, &$msg): bool {
    $start = '<iframe src="https://www.google.com/maps';
    $end = '</iframe>';
    $msg = '';
    if (empty($map)) {
      $msg = "URLを入力してください";
      return false;
    }
    // if (!empty($map) && !preg_match("/^$start/", $map)) {
    // $msg = "正しいマップのURLを入力してください";
    // return false;
    // }
    return true;
  }

  /**
   * 備考の妥当性をチェックします。
   *
   * @param  $comment 備考の内容
   * @param string $msg エラーメッセージを代入
   * @return boolean
   */
  public static function isValidComment($comment, &$msg): bool {
    $msg = '';
    if (strlen($comment) > 1000) {
      $msg = "お問い合わせ内容は1,000文字以内で入力してください。";
      return false;
    }
    return true;
  }

}