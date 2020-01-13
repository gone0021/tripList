-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 
-- サーバのバージョン： 10.4.8-MariaDB
-- PHP のバージョン: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `todo_list`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `todo_items`
--

CREATE TABLE `todo_items` (
  `id` int(11) NOT NULL COMMENT 'ID',
  `expiration_date` date NOT NULL COMMENT '期限日',
  `todo_item` varchar(120) NOT NULL COMMENT 'TODO項目',
  `is_completed` tinyint(4) NOT NULL DEFAULT 0 COMMENT '完了フラグ　0：未完了　1：完了',
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0 COMMENT '削除フラグ　0：未削除　1：削除済み',
  `create_date_time` datetime NOT NULL DEFAULT current_timestamp() COMMENT '登録日時',
  `update_date_time` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT '更新日時'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `todo_items`
--

INSERT INTO `todo_items` (`id`, `expiration_date`, `todo_item`, `is_completed`, `is_deleted`, `create_date_time`, `update_date_time`) VALUES
(1, '2019-12-04', 'aaa', 1, 0, '2019-12-05 03:03:10', '2019-12-05 15:57:02'),
(2, '2019-12-05', 'bbb', 0, 1, '2019-12-05 03:04:37', '2019-12-05 15:56:53'),
(3, '2019-12-06', 'ccc', 0, 0, '2019-12-05 15:36:01', '2019-12-05 15:36:01'),
(4, '2019-12-07', 'ddd', 1, 1, '2019-12-05 15:49:02', '2019-12-05 15:56:53'),
(5, '2019-12-08', 'eee', 0, 0, '2019-12-05 15:56:10', '2019-12-05 15:56:10');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `todo_items`
--
ALTER TABLE `todo_items`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `todo_items`
--
ALTER TABLE `todo_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
