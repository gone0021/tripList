CREATE TABLE `users_groups` (
  `user_id` int(11) NOT NULL COMMENT 'ユーザーID',
  `group_id` int(11) NOT NULL COMMENT 'グループID',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0 COMMENT '削除フラグ',
  `create_date_time` datetime NOT NULL DEFAULT current_timestamp() COMMENT '登録日時',
  `update_date_time` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日時',
  PRIMARY KEY(user_id,group_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='中間テーブル：users:groups';