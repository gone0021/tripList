<?php
/**
 * 共通関数クラスです。
 */
class CommonUtil {

  function tag_kyoka($str){
    $search = array('&lt;b&gt;','&lt;/b&gt;','&lt;u&gt;','&lt;/u&gt;','&lt;strong&gt;','&lt;/strong&gt;');
    $replace = array('<b>','</b>','<u>','</u>','<strong>','</strong>');
   return str_replace($search,$replace,$str);
   }
  /**
   * POSTされたデータをサニタイズします。
   *
   * @param array $before サニタイズ前のPOST配列
   * @return array サニタイズ後のPOST配列
   */
  public static function sanitaize($before) {
    $after = array();
    foreach ($before as $k => $v) {
      $after[$k] = htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
    }

    // 指定のタグを許可する
    $search = array('&lt;b&gt;','&lt;/b&gt;','&lt;u&gt;','&lt;/u&gt;','&lt;strong&gt;','&lt;/strong&gt;');
    $replace = array('<ifarame>','</iframe>');

    return str_replace($search,$replace,$after);
  }

}