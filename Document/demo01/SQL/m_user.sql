
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- テーブルの構造 `m_sys`
--

CREATE TABLE IF NOT EXISTS `m_user` (
    user_id                char(50)                 NOT NULL,
    user_name           varchar(120)           NOT NULL DEFAULT '',
    password             char(255)              NOT NULL,
    update_date         char(15)                NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
--
-- Indexes for table `m_user`
--
ALTER TABLE `m_user`
 ADD PRIMARY KEY (`user_id`);
--
INSERT INTO m_user VALUES('admin','ADMINISTRATOR','paswd','2017-01-25 11:30:00')

