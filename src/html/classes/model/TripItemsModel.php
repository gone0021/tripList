<?php
$root = $_SERVER['DOCUMENT_ROOT'];
$root .= '/data/tripList/html';
require_once($root.'/classes/model/BaseModel.php');

/**
 * 作業項目モデルクラスです。
 */
class TripItemsModel extends BaseModel {
  /**
   * コンストラクタ
   */
  public function __construct() {
    // 親クラスのコンストラクタを呼び出す
    parent::__construct();
  }

  /**
   * IDの整合性チェック
   *
   * @return bool boool型
   */
  public function checkId($id) {
    // $data['id']が存在しなかったら、falseを返却
    if (!isset($id)) {
      return false;
    }

    // $idが数字でなかったら、falseを返却する。
    if (!is_numeric($id)) {
      return false;
    }

    // $idが0以下はありえないので、falseを返却
    if ($id <= 0) {
      return false;
    }
  }

  /**
   * 作業項目を全件取得します。（削除済みの作業項目は含みません）
   *
   * @return array 作業項目の配列
   */
  public function getTripItemAll() {
    $sql = '';
    $sql .= 'SELECT ';
    $sql .= 't.id,';
    $sql .= 't.user_id,';
    $sql .= 'u.name,';
    $sql .= 't.area,';
    $sql .= 't.point,';
    $sql .= 't.date,';
    $sql .= 't.is_went,';
    $sql .= 't.map_item,';
    $sql .= 't.comment ';
    $sql .= 'from trip_items as t ';
    $sql .= 'inner join users as u '; // inner join
    $sql .= 'on t.user_id=u.id ';
    $sql .= 'where t.is_deleted =0 '; // 論理削除されている作業項目は表示対象外
    $sql .= 'order by t.date asc'; // dateの順番に並べる

    $stmt = $this->dbh->prepare($sql);
    $stmt->execute();
    $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $ret;
  }

  /**
   * 作業項目を検索条件で抽出して取得します。（削除済みの作業項目は含みません）
   *
   * @param mixed $search 検索キーワード
   * @return array 作業項目の配列
   */
  public function getTripItemBySearch($search) {
    $sql = '';
    $sql .= 'SELECT ';
    $sql .= 't.id,';
    $sql .= 't.user_id,';
    $sql .= 'u.name,';
    $sql .= 't.area,';
    $sql .= 't.point,';
    $sql .= 't.date,';
    $sql .= 't.is_went,';
    $sql .= 't.map_item,';
    $sql .= 't.comment ';
    $sql .= 'from trip_items as t ';
    $sql .= 'inner join users as u '; // inner join
    $sql .= 'on t.user_id =u.id ';
    $sql .= 'where t.is_deleted =0 '; // where
    $sql .= "and (";
    $sql .= "u.name like :name ";
    $sql .= "or t.area like :area ";
    $sql .= "or t.point like :point ";
    $sql .= "or t.date :date ";
    $sql .= "or t.is_went like :is_went ";
    $sql .= ") ";
    $sql .= 'order by t.date asc'; // dateの順番に並べる

    // bindParam()の第2引数には値を直接入れることができないので
    // 下記のようにして、検索ワードを変数に入れる。
    $likeWord = "%$search%";

    $went='';
    if ($search == '行った') {
      $went = 1;
    } else if ($search == '気になる') {
      $went = 0;
    } else {
      $went = '';
    }

    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':name', $likeWord, PDO::PARAM_STR);
    $stmt->bindParam(':area', $likeWord, PDO::PARAM_STR);
    $stmt->bindParam(':point', $likeWord, PDO::PARAM_STR);
    $stmt->bindParam(':date', $search, PDO::PARAM_STR);
    $stmt->bindParam(':is_went', $went, PDO::PARAM_INT);
    $stmt->execute();
    $ret = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $ret;
  }

  /**
   * 指定IDの作業項目を1件取得（削除済みの作業項目は含まない）
   * @param int $id 作業項目のID番号
   * @return array 項目の配列
   */
  public function getTripItemById($id) {
    // $idが数字でなかったらfalseを返却する。
    $this->checkId($id);

    $sql = '';
    $sql .= 'SELECT ';
    $sql .= 't.id,';
    $sql .= 't.user_id,';
    $sql .= 'u.name,';
    $sql .= 't.area,';
    $sql .= 't.point,';
    $sql .= 't.date,';
    $sql .= 't.is_went,';
    $sql .= 't.map_item,';
    $sql .= 't.comment ';
    $sql .= 'from trip_items as t ';
    $sql .= 'inner join users as u '; // inner join
    $sql .= 'on t.user_id =u.id ';
    $sql .= 'where t.id =:id '; // where
    $sql .= 'and t.is_deleted =0 '; // 論理削除されている作業項目は表示対象外

    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $ret = $stmt->fetch(PDO::FETCH_ASSOC);

    return $ret;
  }

  /**
   * 作業項目を登録
   *
   * @param array $data 作業項目の連想配列
   * @return bool 成功した場合:TRUE、失敗した場合:FALSE
   */
  public function registerTripItem($data) {
    // テーブルの構造でデフォルト値が設定されているカラムをinsert文で指定する必要はありません（特に理由がない限り）。
    $sql = '';
    $sql .= 'INSERT into trip_items (';
    $sql .= 'user_id,';
    $sql .= 'area,';
    $sql .= 'point,';
    $sql .= 'date,';
    $sql .= 'is_went,';
    $sql .= 'map_item,';
    $sql .= 'comment ';
    $sql .= ') values (';
    $sql .= ':user_id,';
    $sql .= ':area,';
    $sql .= ':point,';
    $sql .= ':date,';
    $sql .= ':is_went,';
    $sql .= ':map_item,';
    $sql .= ':comment ';
    $sql .= ')';

    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(':area', $data['area'], PDO::PARAM_STR);
    $stmt->bindParam(':point', $data['point'], PDO::PARAM_STR);
    $stmt->bindParam(':date', $data['date'], PDO::PARAM_STR);
    $stmt->bindParam(':is_went', $data['is_went'], PDO::PARAM_STR);
    $stmt->bindParam(':map_item', $data['map_item'], PDO::PARAM_STR);
    $stmt->bindParam(':comment', $data['comment'], PDO::PARAM_STR);
    $ret = $stmt->execute();

    return $ret;
  }

  /**
   * 指定IDの項目を更新
   *
   * @param array $data 更新する作業項目の連想配列
   * @return bool 成功した場合:TRUE、失敗した場合:FALSE
   */
  public function updateTripItemById($data) {
    $this->checkId($data['id']);

    $sql = '';
    $sql .= 'UPDATE trip_items set ';
    $sql .= 'user_id =:user_id,';
    $sql .= 'area =:area,';
    $sql .= 'point =:point,';
    $sql .= 'date =:date,';
    $sql .= 'is_went =:is_went,';
    $sql .= 'map_item =:map_item,';
    $sql .= 'comment =:comment,';
    $sql .= 'is_deleted =:is_deleted ';  // 現状の仕様では「削除フラグ」をアップデートする必要はないが、今後の仕様追加のために実装しておく。
    $sql .= 'where id =:id'; // where

    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':user_id', $data['user_id'], PDO::PARAM_INT);
    $stmt->bindParam(':area', $data['area'], PDO::PARAM_STR);
    $stmt->bindParam(':point', $data['point'], PDO::PARAM_STR);
    $stmt->bindParam(':date', $data['date'], PDO::PARAM_STR);
    $stmt->bindParam(':is_went', $data['is_went'], PDO::PARAM_STR);
    $stmt->bindParam(':map_item', $data['map_item'], PDO::PARAM_STR);
    $stmt->bindParam(':comment', $data['comment'], PDO::PARAM_STR);
    $stmt->bindParam(':is_deleted', $data['is_deleted'], PDO::PARAM_INT);
    $stmt->bindParam(':id', $data['id'], PDO::PARAM_INT);
    $ret = $stmt->execute();
    
    return $ret;
  }

  /**
   * 指定IDの項目を行った→行きたいを変更
   *
   * @param int $id 項目ID
   * @return bool 成功した場合:TRUE、失敗した場合:FALSE
   */
  public function updateToWant($id) {
    $this->checkId($id);

    $sql = '';
    $sql .= 'UPDATE trip_items set ';
    $sql .= 'is_went =1 ';
    $sql .= 'where id =:id '; // where
    $sql .= 'and is_went =0 '; // 念の為にdbでも状態を確認する

    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $ret = $stmt->execute();

    return $ret;
  }

    /**
   * 指定IDの項目を行きたい→行ったを変更
   *
   * @param int $id 項目ID
   * @return bool 成功した場合:TRUE、失敗した場合:FALSE
   */
  public function updateToWent($id) {
    $this->checkId($id);

    $sql = '';
    $sql .= 'UPDATE trip_items set ';
    $sql .= 'is_went =0 ';
    $sql .= 'where id =:id '; // where
    $sql .= 'and is_went =1 ';

    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $ret = $stmt->execute();

    return $ret;
  }

  /**
   * 指定IDの項目を論理削除します。
   *
   * @param int $id 作業項目ID
   * @return bool 成功した場合:TRUE、失敗した場合:FALSE
   */
  public function deleteTripItemById($id) {
    $this->checkId($id);

    $sql = '';
    $sql .= 'UPDATE trip_items set ';
    $sql .= 'is_deleted =1 ';
    $sql .= 'where id =:id'; // where

    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $ret = $stmt->execute();

    return $ret;
  }
}