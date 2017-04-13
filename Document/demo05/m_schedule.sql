
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


INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'北海道'     ,' '    ,' '    ,' '    ,' '    ,' ');
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'青森'     ,' '    ,' '    ,' '    ,' '    ,' ');
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'岩手'     ,' '    ,' '    ,' '    ,' '    ,' ');
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'宮城'     ,' '    ,' '    ,' '    ,' '    ,' ');
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'秋田'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'山形'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'福島'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'東京'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'神奈川'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'埼玉'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'千葉'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'茨城'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'栃木'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'群馬'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'山梨'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'新潟'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'長野'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'富山'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'石川'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'福井'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'愛知'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'岐阜'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'静岡'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'三重'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'大阪'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'兵庫'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'京都'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'滋賀'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'奈良'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'和歌山'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'鳥取'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'島根'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'岡山'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'広島'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'山口'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'徳島'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'香川'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'愛媛'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'高知'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'福岡'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'大分'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'長崎'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'佐賀'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'熊本'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'宮崎'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'鹿児島'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'沖縄'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'全国'
INSERT INTO m_schedule VALUES( 1  ,'get_coupon'  ,'データ取得'   ,'不明'


, '美容', 'スポーツ:フィットネス', 'スポーツ:その他', '娯楽・レジャー', '衣類', 'その他')





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
