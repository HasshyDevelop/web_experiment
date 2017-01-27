<?php

// DEBUG
function CMN_DebugPrint($PrintStr) {
    $PrintStr = mb_convert_encoding($PrintStr, DEBUG_ENC, "auto");
    if(DEBUG_MODE){
        print $PrintStr.DEBUG_CRLF;
     }
}

// エラー処理用
function CMN_ErrorHandler($errno, $errstr, $errfile, $errline){
    // $errno は error_reporting の値を参照。
    if($errno == 1 || $errno == 2 | $errno == 4){
        // エラー通知処理
        $ErrStr = $errno.":".$errstr.":".$errfile.":".$errline;
        LOG_OutPut(LOG_ERR_EXCEP,$ErrStr);
        CMN_DebugPrint($ErrStr);
    }
}

//  システム日付取得処理
function getSysDate() {
    global $G_MY_SQLI;
    global $G_TODAY, $G_WEEK_BF_DAY;
    global $G_TODAY, $G_1WEEK_BF, $G_1WEEK_AF, $G_1MOTNH_AF;
    global $G_CALEN_Y, $G_CALEN_M, $G_CALEN_D, $G_CALEN_W;

    $strSQL  = "";
    $strSQL .= " SELECT DATE_FORMAT(now(),'".FMT_DAY_SQL."') SYS_TODAY";
    $strSQL .= "       ,DATE_FORMAT(date_sub(now(), INTERVAL 7 DAY),'".FMT_DAY_SQL."') SYS_WEEK_BEFORE";

    $strSQL .= "       ,DATE_FORMAT((now() + INTERVAL 7 DAY),'".FMT_DAY_SQL."')   SYS_WEEK_AFTER";
    $strSQL .= "       ,DATE_FORMAT((now() + INTERVAL 1 MONTH),'".FMT_DAY_SQL."') SYS_MONTH_AFTER";

    if(!$result = $G_MY_SQLI->query($strSQL)){
        $strErr = 'getSysDate : '.Mysql_Error().'::'.$strSQL;
        print $strErr;
        Die();
    }

    while ($row = $result->fetch_assoc()) {
        $G_TODAY = $row['SYS_TODAY'];
        $G_TODAY = date(FMT_DAY_PHP,strtotime($G_TODAY));

        $G_1WEEK_BF  = $row['SYS_WEEK_BEFORE'];
        $G_1WEEK_BF = date(FMT_DAY_PHP,strtotime($G_1WEEK_BF));

        $G_1WEEK_AF  = $row['SYS_WEEK_AFTER'];
        $G_1WEEK_AF  = date(FMT_DAY_PHP,strtotime($G_1WEEK_AF));

        $G_1MOTNH_AF = $row['SYS_MONTH_AFTER'];
        $G_1MOTNH_AF = date(FMT_DAY_PHP,strtotime($G_1MOTNH_AF));


        $G_CALEN_Y   = date('Y',strtotime($G_TODAY));
        $G_CALEN_M   = date('F',strtotime($G_TODAY));
        $G_CALEN_D   = date('d',strtotime($G_TODAY));
        $G_CALEN_W   = date('D',strtotime($G_TODAY));

//        CMN_DebugPrint("**** NOW-DATE  ".$G_TODAY." ****");
    }

}


//-----------------------------------------------------
// 曜日を表示を返す
// $day     日付
// $arrWeek 表示用配列 0が日曜 
//-------------------------------------------------------
function CMN_ReturnWeekNumber($pDay) {

    $wkYear     = date("Y",strtotime($pDay . " 0 day"));
    $wkMonth    = date("m",strtotime($pDay . " 0 day")); 
    $wkDay      = date("d",strtotime($pDay . " 0 day"));

    $dayOfWeek = date("w", mktime(0, 0, 0, $wkMonth, $wkDay, $wkYear));
    return $dayOfWeek;
}

//  システムマスタ取得
function CMN_GetM_SYS() {
    $strSQL = "";
    $strSQL .= "SELECT ";
    $strSQL .= '   AMA_URL                          URL';
    $strSQL .= "  ,DECODE(AMA_ACCESS_KEY,'".DB_DECODE_KEY."')     ACCESS_KEY";
    $strSQL .= "  ,DECODE(AMA_SECRET_KEY,'".DB_DECODE_KEY."')     SECRET_KEY";
    $strSQL .= "  ,AMA_VERSION                      VERSION";
    $strSQL .= "  ,DECODE(AMA_ASSOCIATE_TAG,'".DB_DECODE_KEY."')  ASSOCIATE_TAG";
    $strSQL .= "  ,DECODE(AMA_TRACKING_ID  ,'".DB_DECODE_KEY."')  TRACKING_ID";
    $strSQL .= "  ,AMA_WAIT_TIME                    WAIT_TIME";
    $strSQL .= "  ,AMA_MAX_PAGE_CNT                 MAX_PAGE";
    $strSQL .= " FROM m_sys";

    $Result = Mysql_Query($strSQL);
    //ERROR CHAECK
    if(!$Result){
       //EEOR LOG OUT PUT
        $strErr = 'CMN_GetM_SYS:'.Mysql_Error();
        LOG_OutPut(LOG_ERR_EXCEP,$strErr);
        Die();
    }

    //
    while ($Row = Mysql_Fetch_Assoc($Result)) {
        define('SYS_URL'           , $Row['URL']);
        define('SYS_ACCESS_KEY'    , $Row['ACCESS_KEY']);
        define('SYS_SECRET_KEY'    , $Row['SECRET_KEY']);
        define('SYS_VERSION'       , $Row['VERSION']);
        define('SYS_ASSOCIATE_TAG' , $Row['ASSOCIATE_TAG']);
        define('SYS_TRACKING_ID'   , $Row['TRACKING_ID']);
        define('SYS_WAIT_TIME'     , $Row['WAIT_TIME']);
        define('SYS_MAX_PAGE'      , $Row['MAX_PAGE']);
    }
}

// ASSOCIATE_TAG -> TRACKING_ID
function CMN_ASSOCIATE_TO_TRACKING_CONV($strStr) {

    $strRetrun = '';
    $strRetrun = str_replace(SYS_ASSOCIATE_TAG, SYS_TRACKING_ID, $strStr);

    return $strRetrun;
}

//DB INSERT 用文字列変換
function DB_INS_STR_CONV($strStr) {

    $strRetrun = '';
    $strRetrun = str_replace("'", "''", $strStr);

    return $strRetrun;
}

//  処理待ち
function CMN_WaitSec($dateBefore, $dateAfter, $numWaitSec) {

    $UniBefore = strtotime($dateBefore);  //日付前をUNIXタイム化
    $UniAfter  = strtotime($dateAfter);   //日付後をUNIXタイム化
    $Sa        = $UniAfter - $UniBefore;

    if($Sa <  $numWaitSec){
       sleep($numWaitSec-$Sa);
    }

//   Die();
}

//----------------------------------------------------------------------
// RFC3986 形式で URL エンコードする関数
//----------------------------------------------------------------------
function CMN_UrlEncode_rfc3986($str)
{
       return str_replace('%7E', '~', rawurlencode($str));
}

//----------------------------------------------------------------------

function MY_STR_SPLIT($str, $split_len = 1) {

    mb_internal_encoding('UTF-8');
    mb_regex_encoding('UTF-8');

    if ($split_len <= 0) {
        $split_len = 1;
    }

    $strlen = mb_strlen($str, 'UTF-8');
    $ret    = array();

    for ($i = 0; $i < $strlen; $i += $split_len) {
        $ret[ ] = mb_substr($str, $i, $split_len);
    }
    return $ret;
}
?>

