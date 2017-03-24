
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- テーブルの構造 `m_sys`
--

CREATE TABLE IF NOT EXISTS `m_sys` (
    sys_id                  char(20)                   NOT NULL,
    min_thread_res      int(05)                      DEFAULT 0,



    thread_id                char(10)                 NOT NULL,
    thread_name     varchar(100)           NOT NULL,
    thread_date      varchar(20)             NOT NULL DEFAULT '',
    res_cnt             int(05)                     NOT NULL DEFAULT 0,
    dat_url             varchar(50)              NOT NULL,
    update_date     char(15)                  NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
--
-- Indexes for table `m_sys`
--
ALTER TABLE `m_sys`
 ADD PRIMARY KEY (`sys_id`);
--
-- テーブルのデータのダンプ `wp01_users`
-- 
--
