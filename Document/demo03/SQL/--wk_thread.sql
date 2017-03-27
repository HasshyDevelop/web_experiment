
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- テーブルの構造 `wk_thread`
--

CREATE TABLE IF NOT EXISTS `wk_thread` (
    thread_id          char(20)             NOT NULL,
    thread_name    varchar(100)        NOT NULL,
    sort_cd            char(60)               NOT NULL,
    res_id                int(04)               NOT NULL,
    parent_res_id      int(04)               NOT NULL,
    post_name        varchar(50)         NOT NULL DEFAULT '',
    post_mail          varchar(50)         NOT NULL DEFAULT '',
    post_datetime   char(50)              NOT NULL DEFAULT '',
    post_txt            longtext              NOT NULL DEFAULT '',
    disp_flg             int(01)                NOT NULL DEFAULT 0,
    update_date     char(15)              NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
--
-- Indexes for table `wk_thread`
--
ALTER TABLE `wk_thread` 
 ADD PRIMARY KEY (`thread_id`,`res_id`);
--
-- テーブルのデータのダンプ `wp01_users`
-- 
--
