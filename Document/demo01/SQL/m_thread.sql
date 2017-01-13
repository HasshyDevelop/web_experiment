
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- テーブルの構造 `m_thread`
--

CREATE TABLE IF NOT EXISTS `m_thread` (



    thread_num      int(04)                 NOT NULL,
    res_number      int(04)                 NOT NULL DEFAULT 0,
    post_name        varchar(50)         NOT NULL DEFAULT '',
    post_mail          varchar(50)          NOT NULL DEFAULT '',
    post_datetime   char(20)               NOT NULL DEFAULT '',
    post_txt1          varchar(250)        NOT NULL DEFAULT '',
    post_txt2          varchar(250)        NOT NULL DEFAULT '',
    post_txt3          varchar(250)        NOT NULL DEFAULT '',
    post_txt4          varchar(250)        NOT NULL DEFAULT '',
    post_txt5          varchar(250)        NOT NULL DEFAULT '',
    disp_flg             int(01)                  NOT NULL DEFAULT 0,
    update_date     char(08)        NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
--
-- Indexes for table `my_users_blg`
--
ALTER TABLE `m_thread`
 ADD PRIMARY KEY (`thread_num`,`res_number`);
--
-- テーブルのデータのダンプ `wp01_users`
-- 
--
