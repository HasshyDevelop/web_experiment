
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- テーブルの構造 `d_thread`
--

CREATE TABLE IF NOT EXISTS `d_thread` (
    board_id          char(20)                   NOT NULL,
    board_name     varchar(100)            NOT NULL,
    thread_id          char(10)                  NOT NULL,
    thread_name     varchar(100)           NOT NULL,
    thread_date      varchar(20)             NOT NULL DEFAULT '',
    res_cnt             int(05)                     NOT NULL DEFAULT 0,
    dat_url             varchar(250)           NOT NULL,
    update_date     char(15)                  NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
--
-- Indexes for table `d_thread`
--
ALTER TABLE `d_thread`
 ADD PRIMARY KEY (`board_id`,`thread_id`);
--
-- テーブルのデータのダンプ `wp01_users`
-- 
--
