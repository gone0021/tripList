<?php
/**
 * 共通関数クラスです。
 */
class CommonUtil {

  // function tag_kyoka($str){
  //   $search = array('&lt;b&gt;','&lt;/b&gt;','&lt;u&gt;','&lt;/u&gt;','&lt;strong&gt;','&lt;/strong&gt;');
  //   $replace = array('<b>','</b>','<u>','</u>','<strong>','</strong>');
  //  return str_replace($search,$replace,$str);
  //  }

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
    return $after;

    // 良くない成功例（マッチした時に$beforの全てがサニタイズされない）
    // $after = array();
    //   foreach ($before as $k => $v) {
    //     if (preg_match("/<iframe src=\"https:\/\/www\.google\.com\/map(.*?)<\/iframe>/s", $before[$k])) {
    //       return $before;
    //     } else {
    //       $after[$k] = htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
    //   }
    // }
  
    // 厳密なサニタイズ（GoogleMapタグのみHTML特殊文字をデコード）
    // if (preg_match("/<iframe src=\"https:\/\/www\.google\.com\/map(.*?)<\/iframe>/s", $before[$k])) {
    //   $html = array('&lt;iframe','ENT_QUOTES');
    //   htmlspecialchars_decode($html,ENT_QUOTES);
    // } else {
    // return $after;
  }
}
