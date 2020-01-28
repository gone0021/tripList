CREATE TABLE `trip_items` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL COMMENT 'ID',
  `user_id` int(11) NOT NULL COMMENT 'ユーザーID',
  `area` varchar(255) NOT NULL COMMENT '地域',
  `point` varchar(255) NOT NULL COMMENT '場所名',
  `date` date NOT NULL COMMENT '該当日',
  `is_went` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0：行きたい　1：行った',
  `map_item` text NOT NULL COMMENT 'マップURL',
  `comment` varchar(1000) COMMENT '備考',
  `public_range` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0：個別　1：全グループ　 2：全ユーザー　3：グループごと',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0 COMMENT '削除フラグ、　0：未削除　1：削除済み',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='行きたいリスト';

