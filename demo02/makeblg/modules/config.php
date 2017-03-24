<?php

//DB
define('DB_USER'       , 'root');
define('DB_PASSWORD'   , '');
define('DB_SERVER'     , 'localhost');
define('DB_NAME'       , 'db_demo02');
define('DB_TYPE'       , 'mysql');
define('DB_DECODE_KEY' , 'KEY');

//define('DB_IMG_PTN_S'    , 'S');
//define('DB_IMG_PTN_M'    , 'M');
//define('DB_IMG_PTN_L'    , 'L');

//Mail
define('SMTP_HOST', '');
define('SMTP_PORT', '');
define('SMTP_USER', '');
define('SMTP_PASSWORD', '');

//SYSTEM
define('FMT_DAY_PHP'       , 'Y-m-d');      //システム日付フォーマット PHP用
define('FMT_DAY_PHP_JP'    , 'Y年m月d日');      //システム日付フォーマット PHP用
define('FMT_DAY_SQL'       , '%Y-%m-%d');   //システム日付フォーマット DB用
define('FMT_DAY_TIME_SQL'  , '%Y-%m-%d %T');   //システム日付フォーマット DB用
define('TIME_OUT_LIMIT'    , 120);
define('DELIMITER_IN'      , '<DELIMI>');
define('DELIMITER_OUT'     , ' ');

define('ENC_CODE' , 'utf-8');

define('DEBUG_MODE', True);
define('DEBUG_ENC' , 'shift-jis');
//define('DEBUG_ENC' , 'utf-8');
//define('DEBUG_CRLF', PHP_EOL);
define('DEBUG_CRLF', '<BR>');
define('DEBUG_LOG', True);

//*******************************************************************
//CONST
//*******************************************************************
define('URL_DOMAIN'      ,  'http://localhost/deru/');
define('URL_BBSALL'      ,  'http://menu.2ch.sc/bbsmenu.html');
define('THREAD_TXT_NAME' ,  'subject.txt');     //スレ一覧txtの
//スレッド取得最小レス数
define('MIN_THREAD' ,  200);
define('DEL_TXT_MIN' ,  80);       //短すぎる文字削除用
define('DEL_TXT_LNG' ,  500);      //長すぎる文字削除用
//_FILE PATH
define('PATH_TPL' ,  './modules/tpl/');
//CODE
define('ERR_CD_NODATA' ,  'no_data');
define('SORT_CD_DEF'   ,  '00000');

define('ODR_BOARD' ,  'boad_id');
define('ODR_SORT'  ,  'sort_no');

define('LOGIN_IN'  ,  'login');
define('LOGIN_OUT' ,  'logout');
define('LOGIN_NEW' ,  'new');

//端末情報
//MOBILE = ガラケー = 1
//SMARTPHONE = スマホ = 2
//PC = PC = 10
define('DEVICE_TYPE_MOBILE'      ,  '1');
define('DEVICE_TYPE_SMARTPHONE'  ,  '2');
define('DEVICE_TYPE_PC'          , '10');

//LOG
//define('LOG_BATCH_START', 'BATCH-START');
//define('LOG_BATCH_END'  , 'BATCH-END');
//define('LOG_ERR_EXCEP'  , 'Exception');
//define('LOG_ERR_SQL'    , 'SQL-EEOR');
?>
