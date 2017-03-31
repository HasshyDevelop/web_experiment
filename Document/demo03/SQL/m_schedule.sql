
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- テーブルの構造 `m_schedules`
--

CREATE TABLE IF NOT EXISTS `m_schedule` (
    schedule_no    INT                       NOT NULL,
    exec_id           varchar(250)           NOT NULL,
    memo             longtext                   ,
    general_col01   varchar(250)            ,
    general_col02   varchar(250)            ,
    general_col03   varchar(250)            ,
    general_col04   varchar(250)            ,
    general_col05   varchar(250)            ,
    update_date    char(15)                   NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
--
-- Indexes for table `m_schedule`
--
ALTER TABLE `m_schedule`
 ADD PRIMARY KEY (`schedule_no`);
--
-- テーブルのデータのダンプ `wp01_users`
-- 
--General purpose column

INSERT INTO m_schedule VALUES( 1  ,'get_rss'  ,'ランキングデータ取得'   ,'newsplus'     ,' '    ,' '    ,' '    ,' '    ,' ');
INSERT INTO m_schedule VALUES( 2  ,'get_rss'  ,'ランキングデータ取得'   ,'newsplus'     ,' '    ,' '    ,' '    ,' '    ,' ');
INSERT INTO m_schedule VALUES( 3  ,'get_rss'  ,'ランキングデータ取得'   ,'newsplus'     ,' '    ,' '    ,' '    ,' '    ,' ');
INSERT INTO m_schedule VALUES( 4  ,'get_rss'  ,'ランキングデータ取得'   ,'newsplus'     ,' '    ,' '    ,' '    ,' '    ,' ');
INSERT INTO m_schedule VALUES( 5  ,'get_rss'  ,'ランキングデータ取得'   ,'newsplus'     ,' '    ,' '    ,' '    ,' '    ,' ');

INSERT INTO m_schedule VALUES( 6  ,'make_thread1'  ,'スレデータ　作成　STEP 01'   ,'newsplus'     ,' '    ,' '    ,' '    ,' '    ,' ');
INSERT INTO m_schedule VALUES( 7  ,'make_thread2'  ,'スレデータ　作成　STEP 02'   ,'newsplus'     ,' '    ,' '    ,' '    ,' '    ,' ');
INSERT INTO m_schedule VALUES( 8  ,'make_thread3'  ,'スレデータ　作成　STEP 02'   ,'newsplus'     ,' '    ,' '    ,' '    ,' '    ,' ');
INSERT INTO m_schedule VALUES( 9  ,'get_rss'  ,'ランキングデータ取得'   ,'newsplus'     ,' '    ,' '    ,' '    ,' '    ,' ');
INSERT INTO m_schedule VALUES(10  ,'get_rss'  ,'ランキングデータ取得'   ,'newsplus'     ,' '    ,' '    ,' '    ,' '    ,' ');




define('EXEC_ID_MAKE_BORAD' ,  'make_bord');
define('EXEC_ID_MAKE_THREAD_STEP1' ,  'make_thread1');
define('EXEC_ID_MAKE_THREAD_STEP2' ,  'make_thread2');
define('EXEC_ID_MAKE_THREAD_STEP3' ,  'make_thread3');
