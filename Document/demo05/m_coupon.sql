
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- テーブルの構造 `m_board`
--

CREATE TABLE IF NOT EXISTS `m_coupon` (
    coupon_id                      char(10)                   NOT NULL,
    coupon_area	                   varchar(50),
    coupon_site                    varchar(100),
    coupon_url                      varchar(100),
    coupon_title                    varchar(250),
    coupon_summary             LONGTEXT,
    coupon_addr                   varchar(250),
    coupon_access                varchar(250),
    coupon_teika                    int(07)                    DEFAULT 0,
    coupon_kakaku                 int(07)                    DEFAULT 0,
    coupon_shop                    varchar(100),
    coupon_photo                   varchar(250),
    coupon_lat                       char(15),
    coupon_lng                       char(15),
    coupon_untilldatetime        char(20),
    coupon_max                     int(07)                    DEFAULT 0,
    coupon_sold                     int(07)                    DEFAULT 0,
    priority                            char(5),
    coupon_site_url                 varchar(250),
    category_type                  varchar(50),
    category_name                 varchar(50),
    site_code                         char(20) ,
    update_date                     char(15)                   NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
--
-- Indexes for table `m_coupon`
--
ALTER TABLE `m_coupon`
 ADD PRIMARY KEY (`coupon_id`);
--
-- テーブルのデータのダンプ `wp01_users`
-- 
--
