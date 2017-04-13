
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- テーブルの構造 `d_task`
--

CREATE TABLE IF NOT EXISTS `m_sys` (
    id                   char(10)                NOT NULL,
    apikey             char(100)              NOT NULL,
    url                  varchar(250)         ,
    update_date    char(15)                  NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
--
-- Indexes for table `m_schedule`
--
ALTER TABLE `d_task`
 ADD PRIMARY KEY (`id`);
--
-- テーブルのデータのダンプ
-- 
;
