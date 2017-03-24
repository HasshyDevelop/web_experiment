
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- テーブルの構造 `m_board`
--

CREATE TABLE IF NOT EXISTS `m_board` (
    board_id          char(20)                   NOT NULL,
    board_name     varchar(100)             NOT NULL,
    board_url          varchar(250)            NOT NULL,
    sort_no            int(05)                     NOT NULL DEFAULT 0,
    update_date      char(15)                   NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
--
-- Indexes for table `m_board`
--
ALTER TABLE `m_board`
 ADD PRIMARY KEY (`board_id`,`board_name`);
--
-- テーブルのデータのダンプ `wp01_users`
-- 
--
