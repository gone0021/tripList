CREATE TABLE `groups` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL COMMENT 'ID',
  `gruou_name` varchar(255) NOT NULL COMMENT 'グループ名',
  `user_id` int(11) NOT NULL COMMENT 'ユーザーID、　join用',
  `is_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '削除フラグ',
  `create_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `update_date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='グループ';