
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- テーブルの構造 `d_ranking`
--

CREATE TABLE IF NOT EXISTS `d_ranking` (
    blg_id                  char(20)            NOT NULL,
    thread_id             varchar(100)      NOT NULL,
    max_rank             char(3)              NOT NULL,
    point                   varchar(100)      NOT NULL,
    update_date         char(15)            NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
--
-- Indexes for table `d_ranking`
--
ALTER TABLE `d_ranking` 
 ADD PRIMARY KEY (blg_id, thread_id);
--
-- テーブルのデータのダンプ `wp01_users`
-- 
--
    