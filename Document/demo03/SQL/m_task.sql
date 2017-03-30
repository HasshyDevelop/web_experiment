
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- テーブルの構造 `m_task`
--

CREATE TABLE IF NOT EXISTS `m_task` (
    id                  char(2)                   NOT NULL,
    exec_order      int(1)                      NOT NULL,
    exec_type       varchar(250)            NOT NULL,
    memo             longtext                   ,
    general_col01   varchar(250)            ,
    general_col02   varchar(250)            ,
    general_col03   varchar(250)            ,
    general_col04   varchar(250)            ,
    general_col05   varchar(250)            ,
    update_date    char(15)                   NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
--
-- Indexes for table `m_board`
--
ALTER TABLE `m_task`
 ADD PRIMARY KEY (`id`);
--
-- テーブルのデータのダンプ `wp01_users`
-- 
--General purpose column

INSERT INTO m_task VALUES('1'        ,1     ,'get_rss'      ,'ランキングデータ取得','newsplus',' ',' ',' ',' ',' ');
INSERT INTO m_task VALUES('2'        ,2     ,'get_rss'      ,'ランキングデータ取得','newsplus',' ',' ',' ',' ',' ');
INSERT INTO m_task VALUES('3'        ,3     ,'get_rss'      ,'ランキングデータ取得','newsplus',' ',' ',' ',' ',' ');
INSERT INTO m_task VALUES('4'        ,4     ,'get_rss'      ,'ランキングデータ取得','newsplus',' ',' ',' ',' ',' ');
INSERT INTO m_task VALUES('5'        ,5     ,'get_rss'      ,'ランキングデータ取得','newsplus',' ',' ',' ',' ',' ');
INSERT INTO m_task VALUES('6'        ,6     ,'get_rss'      ,'ランキングデータ取得','newsplus',' ',' ',' ',' ',' ');
INSERT INTO m_task VALUES('7'        ,7     ,'get_rss'      ,'ランキングデータ取得','newsplus',' ',' ',' ',' ',' ');
INSERT INTO m_task VALUES('8'        ,8     ,'get_rss'      ,'ランキングデータ取得','newsplus',' ',' ',' ',' ',' ');
INSERT INTO m_task VALUES('9'        ,9     ,'get_rss'      ,'ランキングデータ取得','newsplus',' ',' ',' ',' ',' ');
INSERT INTO m_task VALUES('10'     ,10    , 'get_rss'       ,'ランキングデータ取得','newsplus',' ',' ',' ',' ',' ');
