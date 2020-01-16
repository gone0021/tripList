CREATE TABLE `users` (
  `id` int(11) AUTO_INCREMENT PRIMARY KEY NOT NULL COMMENT 'ID',
  `name` varchar(50) NOT NULL COMMENT 'ユーザー名',
  `email` varchar(255) NOT NULL COMMENT 'メールアドレス、ログインID',
  `birthday` date NOT NULL COMMENT '誕生日',
  `password` varchar(255) NOT NULL COMMENT 'パスワード',
  `is_admin` tinyint(4) NOT NULL DEFAULT 0 COMMENT '管理者権限、　0：権限なし　1：M管理者　2：G管理者',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0 COMMENT '削除フラグ、　0：未削除　1：削除済み',
  `create_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '登録日時',
  `update_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='ユーザー';

