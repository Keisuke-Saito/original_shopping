-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost
-- 生成日時: 2022 年 10 月 05 日 12:34
-- サーバのバージョン： 10.5.8-MariaDB
-- PHP のバージョン: 7.4.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `shopping`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(32) DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `product_image` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `product_image`, `content`, `created`, `modified`) VALUES
(15, 'ぶどう', 500, 'img_63288895952d0.png', 'みずみずしい粒と爽やかな酸味が特徴です。', '2022-09-19 15:19:49', '2022-09-19 15:19:49'),
(16, 'レモン', 300, 'img_632c02f8352f1.png', 'さっぱりとした味わいです。無農薬で栽培しました。', '2022-09-22 06:38:48', '2022-09-22 06:38:48'),
(21, 'メロン', 1500, 'img_632c80f29db15.png', '甘味が凝縮された大玉のメロンです。北海道産です。', '2022-09-22 15:36:18', '2022-09-22 15:36:18'),
(22, 'もも', 400, 'img_6332325496b63.png', '程よい甘さです。', '2022-09-26 23:14:28', '2022-09-26 23:14:28'),
(24, 'みかん', 150, 'img_6334046ba78e2.png', '皮まで食べられます。', '2022-09-28 08:23:07', '2022-09-28 08:23:07'),
(26, 'りんご', 300, 'img_63340d8ba8c5e.png', '赤いです。', '2022-09-28 09:02:03', '2022-09-28 09:02:03');

-- --------------------------------------------------------

--
-- テーブルの構造 `product_sales`
--

CREATE TABLE `product_sales` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `product_sales`
--

INSERT INTO `product_sales` (`id`, `product_id`, `quantity`, `user_id`, `created`) VALUES
(145, 21, 3, 5, '2022-09-29 12:34:19'),
(146, 24, 1, 5, '2022-09-29 12:34:20'),
(152, 22, 7, 5, '2022-09-30 17:58:36'),
(174, 16, 2, 4, '2022-10-05 08:00:58'),
(176, 21, 3, 4, '2022-10-05 08:01:01'),
(178, 22, 4, 4, '2022-10-05 08:01:04'),
(179, 24, 5, 4, '2022-10-05 08:01:06'),
(181, 15, 6, 5, '2022-10-05 08:35:31'),
(182, 15, 5, 9, '2022-10-05 08:37:27'),
(183, 21, 10, 9, '2022-10-05 08:37:31'),
(184, 24, 7, 9, '2022-10-05 08:37:34'),
(185, 26, 8, 9, '2022-10-05 08:37:37'),
(186, 26, 5, 11, '2022-10-05 09:20:35');

-- --------------------------------------------------------

--
-- テーブルの構造 `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(32) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `authority` int(11) DEFAULT 1,
  `delflag` tinyint(1) DEFAULT 0,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `authority`, `delflag`, `created`, `modified`) VALUES
(4, 'aaaa', 'test@test.com', '$2y$10$v5JePyIpnxQrDejpPoyVMO369YLAP8jiphyq6KXJkF0Y2/C70ZhS.', 1, 0, '2022-09-14 15:45:28', '2022-09-30 18:46:46'),
(5, '管理者', 'admin@test.com', '$2y$10$S1mETe2XhHJ60FoetCKpUeFd4sa4F1v4PTC1Y7pswG0.CMiSG5u.e', 99, 0, '2022-09-22 15:54:25', '2022-10-05 03:20:20'),
(11, 'テスト', 'test2@test.com', '$2y$10$zvLDti8qxKeb/S7AgPCJeuir0mvsz9ufAOwP1N.aal6TE1bgWQesS', 1, 1, '2022-10-05 09:20:25', '2022-10-05 09:22:12');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `product_sales`
--
ALTER TABLE `product_sales`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- テーブルの AUTO_INCREMENT `product_sales`
--
ALTER TABLE `product_sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;

--
-- テーブルの AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
