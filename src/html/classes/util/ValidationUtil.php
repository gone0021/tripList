<?php
/**
 * バリデーションユーティリティクラス
 */
class ValidationUtil {
  /**
   * 名前の妥当性をチェック
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
    if (!empty($email) && !preg_match('|^[0-9a-z_./?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$|', $email)) {
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
  public static function isDate($date, &$msg): bool {
    // strtotime()関数を使って、タイムスタンプに変換できるかどうかで正しい日付かどうかを調べます。
    // https://www.php.net/manual/ja/function.strtotime.php
    // 参照
    $msg = '';
    if (empty($date)) {
      $msg = "誕生日を入力してください";
      return false;
    }
    
    if (!strtotime($date)) {
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
    if (strlen($pass) < 6) {
      $msg = "6文字以上で入力してください";
      return false;
    }
    return true;
  }

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
}