
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- テーブルの構造 `m_feed_account`
--

CREATE TABLE IF NOT EXISTS `m_feed_account` (
    id                       char(20)            NOT NULL,
    name                  varchar(100)      NOT NULL,
    url                      varchar(100)      NOT NULL,
    blg_id                   char(20)            NOT NULL,
    make_ptn             int(01)               NOT NULL  DEFAULT 1,
    update_date         char(15)            NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
--
-- Indexes for table `m_feed_account`
--
ALTER TABLE `m_feed_account` 
 ADD PRIMARY KEY (id);
--
-- テーブルのデータのダンプ `wp01_users`
-- 
--
    