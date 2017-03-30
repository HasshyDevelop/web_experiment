
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- テーブルの構造 `d_ranking`
--

CREATE TABLE IF NOT EXISTS `d_ranking` (
    board_id               char(20)            NOT NULL,
    thread_id             varchar(100)      NOT NULL,
    time_key              char(20)            NOT NULL,
--    thread_name        varchar(100)      ,
    max_rank             char(3)              NOT NULL,
    point                   int(5)                 NOT NULL DEFAULT 0,
    read_url          varchar(250)            NOT NULL,
    dat_url             varchar(250)           NOT NULL,
    update_date         char(15)            NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
--
-- Indexes for table `d_ranking`
--
ALTER TABLE `d_ranking` 
 ADD PRIMARY KEY (board_id, thread_id, time_key);
--
-- テーブルのデータのダンプ `wp01_users`
-- 
--
    