<?php
// require_once($_SERVER["DOCUMENT_ROOT"]."/classes/model/BaseModel.php");
$root = $_SERVER["DOCUMENT_ROOT"];
$root .= "/data/tripList/html/classes";
require_once($root."/model/BaseModel.php");

/**
 * ユーザーモデルクラスです。
 */
class UsersModel extends BaseModel {
  /**
   * コンストラクタです。
   */
  public function __construct() {
    // 親クラスのコンストラクタを呼び出す
    parent::__construct();
  }

  /**
   * すべてのユーザーの情報を取得
   *
   * @return array ユーザーのレコードの配列
   */
  public function getUserAll() {
    // 登録済みのカラムをセレクトで取得
    $sql = "";
    $sql .= "select ";
    $sql .= "id,";
    $sql .= "user,";
    $sql .= "pass,";
    $sql .= "mail,";
    $sql .= "birthday,";
    $sql .= "admin ";
    $sql .= "from users ";
    $sql .= "where is_deleted = 0 ";  // 論理削除されているユーザーログイン対象外
    $sql .= "order by id";

    // セッティング情報をSQL文にセット
    $stmt = $this->dbh->prepare($sql);
    // SQL文の実行
    $stmt->execute();
    // PDO::FETCH_ASSOC：カラム名をキーとする連想配列で取得
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /**
   * ユーザーを検索してユーザーの情報を取得
   *
   * @param string $user ユーザー名
   * @param striong $password パスワード
   * @return array ユーザー情報の配列（該当のユーザーが見つからないときは空の配列）
   */
  public function getUser($user, $password) {
    // $userが空だったら、空の配列を返却
    if (empty($user)) {
      return array();
    }

    // 登録済みのカラムをセレクトで取得
    $sql = "";
    $sql .= "select ";
    $sql .= "id,";
    $sql .= "user,";
    $sql .= "pass,";
    $sql .= "mail,";
    $sql .= "birthday,";
    $sql .= "admin ";
    $sql .= "from users ";
    $sql .= "where is_deleted = 0 ";  // 論理削除されているユーザーはログイン対象外
    $sql .= "and user = :user";

    // セレクトで取得した情報をSQL文にセット
    $stmt = $this->dbh->prepare($sql);
    // パラメータをバインド
    $stmt->bindParam(":user", $user, PDO::PARAM_STR);
    // SQL文の実行
    $stmt->execute();
    // PDO::FETCH_ASSOC：カラム名をキーとする連想配列で取得
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);

    // 検索結果が0件のときは空の配列を返却
    if (!$rec) {
      return array();
    }

    // パスワードの妥当性チェックを行い、妥当性がないときは空の配列を返却
    // password_verify()は以下を参照
    // https://www.php.net/manual/ja/function.password-verify.php
    if (!password_verify($password, $rec["pass"])) {
      return array();
    }

    // パスワードの情報は削除する→不要な情報は保持しない（セキュリティ対策）
    unset($rec["pass"]);

    return $rec;
  }

  /**
   * 指定IDのユーザーが存在するかどうか調べる
   *
   * @param int $id ユーザーID
   * @return boolean ユーザーが存在するとき：true、ユーザーが存在しないとき：false
   */
  public function isExistsUser($id) {
    // ＄idが数字でなかったら、falseを返却
    if (!is_numeric($id)) {
      return false;
    }

    // $idが0以下はありえないので、falseを返却
    if ($id <= 0) {
      return false;
    }

    $sql = "";
    $sql .= "select count(id) as num from users where is_deleted　=　0";
    $stmt = $this->dbh->prepare($sql);
    $stmt->execute();
    $ret = $stmt->fetch(PDO::FETCH_ASSOC);

    // レコードの数が0だったらfalseを返却
    if ($ret["num"] == 0) {
      return false;
    }

    return true;
  }
}