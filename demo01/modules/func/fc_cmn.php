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
//  検索結果表示
//----------------------------------------------------------------------
function CMN_GetSearchUrl($ArrParams, $ItemPage, $PubDate) {
    // 基本的なリクエストを作成します
    // - この部分は今まで通り
    $Params                    = Array();
    $Params['Service']         = 'AWSECommerceService';
    $Params['AWSAccessKeyId']  = SYS_ACCESS_KEY;
    $Params['Version']         = SYS_VERSION;
    $Params['Operation']       = 'ItemSearch';
    $Params['AssociateTag']    = SYS_ASSOCIATE_TAG;
    $Params['BrowseNode']      = $ArrParams['BROWSE_NODE'];
    $Params['Sort']            = $ArrParams['SORT_STR']; 
    $Params['SearchIndex']     = $ArrParams['SEARCHI_INDEX'];; 
    $Params['Timestamp']       = gmdate('Y-m-d\TH:i:s\Z');
    $Params['ItemPage']        = $ItemPage;

    switch( $ArrParams['SEARCH_PTN'] ){
      case "1":
            //本
            if(Trim($PubDate) <> ''){
                $Params['Power']           = 'pubdate:during ' .$PubDate;
            }
            break;
      case "3":
            //DVD
            $Params['ReleaseDate'] = $PubDate;
            break;
      default:
            break;
    }



//    $Params['ResponseGroup']   = 'Request,ItemAttributes,Small,Images,Offers';
    $Params['ResponseGroup']   = 'Request,ItemAttributes,Small,Images,Offers';

    // パラメータの順序を昇順に並び替えます
    ksort($Params);

    // canonical string を作成します
    $canonical_string = '';
    foreach ($Params as $k => $v) {
        $canonical_string .= '&'.CMN_UrlEncode_rfc3986($k).'='.CMN_UrlEncode_rfc3986($v);
    }
    $canonical_string = substr($canonical_string, 1);

    // 署名を作成します
    // - 規定の文字列フォーマットを作成
    // - HMAC-SHA256 を計算
    // - BASE64 エンコード
    $parsed_url     = parse_url(SYS_URL);
    $string_to_sign = "GET\n{$parsed_url['host']}\n{$parsed_url['path']}\n{$canonical_string}";
    $signature      = base64_encode(hash_hmac('sha256', $string_to_sign, SYS_SECRET_KEY, true));

    // URL を作成します
    // - リクエストの末尾に署名を追加
    $strUrl = SYS_URL.'?'.$canonical_string.'&Signature='.CMN_UrlEncode_rfc3986($signature);

//    CMN_DebugPrint($strUrl);

    return $strUrl;

}


//*******************************************
// M_CATE_TO_ASIN INAERT
//*******************************************
function CMN_M_CATE_TO_ASIN_InsUpd($InsValue) {
    try{
        //存在チェック
        $strSQL  = "";
        $strSQL .= " SELECT";
        $strSQL .= "     CATEGORY_CODE_L , CATEGORY_CODE_M , ASIN";
        $strSQL .= " FROM M_CATE_TO_ASIN";
        $strSQL .= " WHERE";
        $strSQL .= "       CATEGORY_CODE_L = '".$InsValue['CATEGORY_CODE_L']."'";
        $strSQL .= "   AND CATEGORY_CODE_M = '".$InsValue['CATEGORY_CODE_M']."'";
        $strSQL .= "   AND ASIN            = '".$InsValue['ASIN']."'";

        $Result = Mysql_Query($strSQL);
        //ERROR CHAECK
        if(!$Result){
            $strErr = 'CMN_M_CATE_TO_ASIN_InsUpd : '.Mysql_Error().'::'.$strSQL;
            LOG_OutPut(LOG_ERR_SQL,$strErr);
//           Die();
        }
        $RowCnt = Mysql_Num_Rows($Result);

        if($RowCnt == 0){
            //INSERT
            $strSQL = "";
            $strSQL .= "INSERT INTO M_CATE_TO_ASIN ";
            $strSQL .= " (";
            $strSQL .= "  CATEGORY_CODE_L , CATEGORY_CODE_M , ASIN, UPDATE_DATE";
            $strSQL .= ") VALUES (";
            $strSQL .= "  '".$InsValue['CATEGORY_CODE_L']."'";
            $strSQL .= " ,'".$InsValue['CATEGORY_CODE_M']."'";
            $strSQL .= " ,'".$InsValue['ASIN']."'";
            $strSQL .= " , ".$InsValue['UPDATE_DATE']." ";
            $strSQL .= ")";

            $Result = Mysql_Query($strSQL);

            if(!$Result){
                $strErr = 'CMN_M_CATE_TO_ASIN_InsUpd : '.Mysql_Error().'::'.$strSQL;
                LOG_OutPut(LOG_ERR_SQL,$strErr);
        //       Die();
            }
        }
    } catch (Exception $e) {
        $ErrStr = 'CMN_M_CATE_TO_ASIN_InsUpd:'.$e->getMessage();
        LOG_OutPut(LOG_ERR_EXCEP,$ErrStr);
//        Die($e->getMessage());
        define('BAT_ERR_CHK'    , 'ERR');
//  Die();
    }
}

//*******************************************
// M_ITEM
//*******************************************
//INS
function CMN_M_ITEM_Ins($InsValue) {

    $strSQL = "";
    $strSQL .= "INSERT INTO M_ITEM ";
    $strSQL .= " (";
    $strSQL .= "  ASIN,";
    $strSQL .= "  JAN,";
    $strSQL .= "  TITLE,";
    $strSQL .= "  RELEASE_DATE,";
    $strSQL .= "  PRICE_NUMBER,";
    $strSQL .= "  PRICE_DISP,";
    $strSQL .= "  DETAIL_PAGE_URL,";
    $strSQL .= "  WISH_URL,";
    $strSQL .= "  FRIEND_URL,";
    $strSQL .= "  CUSTOMER_URL,";
    $strSQL .= "  OFFERS_URL,";
    $strSQL .= "  INFO_NAME_1,";
    $strSQL .= "  INFO_VALUE_1,";
    $strSQL .= "  INFO_NAME_2,";
    $strSQL .= "  INFO_VALUE_2,";
    $strSQL .= "  INFO_NAME_3,";
    $strSQL .= "  INFO_VALUE_3,";
    $strSQL .= "  INFO_NAME_4,";
    $strSQL .= "  INFO_VALUE_4,";
    $strSQL .= "  INFO_NAME_5,";
    $strSQL .= "  INFO_VALUE_5,";
    $strSQL .= "  INFO_NAME_6,";
    $strSQL .= "  INFO_VALUE_6,";
    $strSQL .= "  INFO_NAME_7,";
    $strSQL .= "  INFO_VALUE_7,";
    $strSQL .= "  INFO_NAME_8,";
    $strSQL .= "  INFO_VALUE_8,";
    $strSQL .= "  INFO_NAME_9,";
    $strSQL .= "  INFO_VALUE_9,";
    $strSQL .= "  MAKE_DATE ,";
    $strSQL .= "  UPDATE_DATE ";
    $strSQL .= ") VALUES (";
    $strSQL .= "  '".$InsValue['ASIN']."'";
    $strSQL .= " ,'".$InsValue['JAN']."'";
    $strSQL .= " ,'".$InsValue['TITLE']."'";
    $strSQL .= " ,'".$InsValue['RELEASE_DATE']."'";
    $strSQL .= " ,'".$InsValue['PRICE_NUMBER']."'";
    $strSQL .= " ,'".$InsValue['PRICE_DISP']."'";
    $strSQL .= " ,'".$InsValue['DETAIL_PAGE_URL']."'";
    $strSQL .= " ,'".$InsValue['WISH_URL']."'";
    $strSQL .= " ,'".$InsValue['FRIEND_URL']."'";
    $strSQL .= " ,'".$InsValue['CUSTOMER_URL']."'";
    $strSQL .= " ,'".$InsValue['OFFERS_URL']."'";
    $strSQL .= " ,'".$InsValue['INFO_NAME_1']."'";
    $strSQL .= " ,'".$InsValue['INFO_VALUE_1']."'";
    $strSQL .= " ,'".$InsValue['INFO_NAME_2']."'";
    $strSQL .= " ,'".$InsValue['INFO_VALUE_2']."'";
    $strSQL .= " ,'".$InsValue['INFO_NAME_3']."'";
    $strSQL .= " ,'".$InsValue['INFO_VALUE_3']."'";
    $strSQL .= " ,'".$InsValue['INFO_NAME_4']."'";
    $strSQL .= " ,'".$InsValue['INFO_VALUE_4']."'";
    $strSQL .= " ,'".$InsValue['INFO_NAME_5']."'";
    $strSQL .= " ,'".$InsValue['INFO_VALUE_5']."'";
    $strSQL .= " ,'".$InsValue['INFO_NAME_6']."'";
    $strSQL .= " ,'".$InsValue['INFO_VALUE_6']."'";
    $strSQL .= " ,'".$InsValue['INFO_NAME_7']."'";
    $strSQL .= " ,'".$InsValue['INFO_VALUE_7']."'";
    $strSQL .= " ,'".$InsValue['INFO_NAME_8']."'";
    $strSQL .= " ,'".$InsValue['INFO_VALUE_8']."'";
    $strSQL .= " ,'".$InsValue['INFO_NAME_9']."'";
    $strSQL .= " ,'".$InsValue['INFO_VALUE_9']."'";
    $strSQL .= " , ".$InsValue['MAKE_DATE']." ";
    $strSQL .= " , ".$InsValue['UPDATE_DATE']." ";
    $strSQL .= ")";

    $Result = Mysql_Query($strSQL);

    if(!$Result){
        $strErr = 'CMN_M_ITEM_Ins : '.Mysql_Error().'::'.$strSQL;
        LOG_OutPut(LOG_ERR_SQL,$strErr);
//       Die();
    }
}

// UPDATE
function CMN_M_ITEM_Upd($UpdValue) {

    $strSQL = "";
    $strSQL .= "UPDATE M_ITEM SET ";
    $strSQL .= "  JAN             = '".$UpdValue['JAN']."'";
    $strSQL .= " ,TITLE           = '".$UpdValue['TITLE']."'";
    $strSQL .= " ,RELEASE_DATE    = '".$UpdValue['RELEASE_DATE']."'";
    $strSQL .= " ,PRICE_NUMBER    = '".$UpdValue['PRICE_NUMBER']."'";
    $strSQL .= " ,PRICE_DISP      = '".$UpdValue['PRICE_DISP']."'";
    $strSQL .= " ,DETAIL_PAGE_URL = '".$UpdValue['DETAIL_PAGE_URL']."'";
    $strSQL .= " ,WISH_URL        = '".$UpdValue['WISH_URL']."'";
    $strSQL .= " ,FRIEND_URL      = '".$UpdValue['FRIEND_URL']."'";
    $strSQL .= " ,CUSTOMER_URL    = '".$UpdValue['CUSTOMER_URL']."'";
    $strSQL .= " ,OFFERS_URL      = '".$UpdValue['OFFERS_URL']."'";
    $strSQL .= " ,INFO_NAME_1     = '".$UpdValue['INFO_NAME_1']."'";
    $strSQL .= " ,INFO_VALUE_1    = '".$UpdValue['INFO_VALUE_1']."'";
    $strSQL .= " ,INFO_NAME_2     = '".$UpdValue['INFO_NAME_2']."'";
    $strSQL .= " ,INFO_VALUE_2    = '".$UpdValue['INFO_VALUE_2']."'";
    $strSQL .= " ,INFO_NAME_3     = '".$UpdValue['INFO_NAME_3']."'";
    $strSQL .= " ,INFO_VALUE_3    = '".$UpdValue['INFO_VALUE_3']."'";
    $strSQL .= " ,INFO_NAME_4     = '".$UpdValue['INFO_NAME_4']."'";
    $strSQL .= " ,INFO_VALUE_4    = '".$UpdValue['INFO_VALUE_4']."'";
    $strSQL .= " ,INFO_NAME_5     = '".$UpdValue['INFO_NAME_5']."'";
    $strSQL .= " ,INFO_VALUE_5    = '".$UpdValue['INFO_VALUE_5']."'";
    $strSQL .= " ,INFO_NAME_6     = '".$UpdValue['INFO_NAME_6']."'";
    $strSQL .= " ,INFO_VALUE_6    = '".$UpdValue['INFO_VALUE_6']."'";
    $strSQL .= " ,INFO_NAME_7     = '".$UpdValue['INFO_NAME_7']."'";
    $strSQL .= " ,INFO_VALUE_7    = '".$UpdValue['INFO_VALUE_7']."'";
    $strSQL .= " ,INFO_NAME_8     = '".$UpdValue['INFO_NAME_8']."'";
    $strSQL .= " ,INFO_VALUE_8    = '".$UpdValue['INFO_VALUE_8']."'";
    $strSQL .= " ,INFO_NAME_9     = '".$UpdValue['INFO_NAME_9']."'";
    $strSQL .= " ,INFO_VALUE_9    = '".$UpdValue['INFO_VALUE_9']."'";
//    $strSQL .= " ,MAKE_DATE    = '".$UpdValue['MAKE_DATE']."'";
    $strSQL .= " ,UPDATE_DATE     =  ".$UpdValue['UPDATE_DATE']." ";
    $strSQL .= " WHERE ";
    $strSQL .= "  ASIN            = '".$UpdValue['ASIN']."'";

//CMN_DebugPrint($InsValue['INFO_NAME_1']);

    $Result = Mysql_Query($strSQL);

    if(!$Result){
        $strErr = 'CMN_M_ITEM_Upd : '.Mysql_Error().'::'.$strSQL;
        LOG_OutPut(LOG_ERR_SQL,$strErr);
//       Die();
    }

}

//*******************************************
// CMN_D_RELEASE_HISTORY_Ins
//*******************************************
function CMN_D_RELEASE_HISTORY_InsUpd($InsValue, $strBeforeDate) {
    global $G_TODAY;

    try{
        //存在チェック
        $strSQL  = "";
        $strSQL .= " SELECT";
        $strSQL .= "   ASIN         ";
        $strSQL .= "  ,CHANGE_DATE ";
        $strSQL .= "  ,BEFORE_RELEASE_DATE ";
        $strSQL .= "  ,AFTER_RELEASE_DATE ";
        $strSQL .= " FROM";
        $strSQL .= "   D_RELEASE_HISTORY";
        $strSQL .= " WHERE";
        $strSQL .= "      ASIN        = '".$InsValue['ASIN']."'";
        $strSQL .= "  AND CHANGE_DATE = '".$G_TODAY."'";

        $Result = Mysql_Query($strSQL);
        //ERROR CHAECK
        if(!$Result){
            $strErr = 'CMN_D_RELEASE_HISTORY_InsUpd : '.Mysql_Error().'::'.$strSQL;
            LOG_OutPut(LOG_ERR_SQL,$strErr);
//            Die();
        }
        $RowCnt = Mysql_Num_Rows($Result);

        if($RowCnt == 0){
            //INSERT
            $strSQL = "";
            $strSQL .= "INSERT INTO D_RELEASE_HISTORY ";
            $strSQL .= " (";
            $strSQL .= "   ASIN, CHANGE_DATE, BEFORE_RELEASE_DATE, AFTER_RELEASE_DATE, UPDATE_DATE";
            $strSQL .= ") VALUES (";
            $strSQL .= "  '".$InsValue['ASIN']."'";
            $strSQL .= " ,'".$G_TODAY."'";
            $strSQL .= " ,'".$strBeforeDate."'";
            $strSQL .= " ,'".$InsValue['RELEASE_DATE']."' ";
            $strSQL .= " , ".$InsValue['UPDATE_DATE']." ";
            $strSQL .= ")";
        }else{
            //UPDATE
            $strSQL = "";
            $strSQL .= "UPDATE D_RELEASE_HISTORY SET ";
            $strSQL .= "  BEFORE_RELEASE_DATE = '".$strBeforeDate."'";
            $strSQL .= " ,AFTER_RELEASE_DATE  = '".$InsValue['RELEASE_DATE']."' ";
            $strSQL .= " ,UPDATE_DATE         =  ".$InsValue['UPDATE_DATE']." ";
            $strSQL .= " WHERE";
            $strSQL .= "      ASIN            = '".$InsValue['ASIN']."'";
            $strSQL .= "  AND CHANGE_DATE     = '".$G_TODAY."'";
        }
        $Result = Mysql_Query($strSQL);


        if(!$Result){
           //EEOR LOG OUT PUT
            $strErr = 'CMN_D_RELEASE_HISTORY_InsUpd : '.Mysql_Error().'::'.$strSQL;
            LOG_OutPut(LOG_ERR_SQL,$strErr);
    //       Die();
        }
    } catch (Exception $e) {
        $ErrStr = 'CMN_D_RELEASE_HISTORY_InsUpd:'.$e->getMessage();
        LOG_OutPut(LOG_ERR_EXCEP,$ErrStr);
//        Die($e->getMessage());
        define('BAT_ERR_CHK'    , 'ERR');
    }
}


//*******************************************
// M_ITEM_IMG
//*******************************************
//INS
function CMN_M_ITEM_IMG_Ins($InsValue) {

    $strSQL = "";
    $strSQL .= "INSERT INTO M_ITEM_IMG ";
    $strSQL .= " (";
    $strSQL .= "  ASIN,";
    $strSQL .= "  IMG_PTN,";
    $strSQL .= "  IMG_NO,";
    $strSQL .= "  IMG_URL,";
    $strSQL .= "  IMG_HEIGHT,";
    $strSQL .= "  IMG_WIDTH,";
    $strSQL .= "  UPDATE_DATE ";
    $strSQL .= ") VALUES (";
    $strSQL .= "  '".$InsValue['ASIN']."'";
    $strSQL .= " ,'".$InsValue['IMG_PTN']."'";
    $strSQL .= " ,'".$InsValue['IMG_NO']."'";
    $strSQL .= " ,'".$InsValue['IMG_URL']."'";
    $strSQL .= " ,'".$InsValue['IMG_HEIGHT']."'";
    $strSQL .= " ,'".$InsValue['IMG_WIDTH']."'";
    $strSQL .= " , ".$InsValue['UPDATE_DATE']." ";
    $strSQL .= ")";

    $Result = Mysql_Query($strSQL);

    if(!$Result){
        $strErr = 'CMN_M_ITEM_IMG_Ins : '.Mysql_Error().'::'.$strSQL;
        LOG_OutPut(LOG_ERR_SQL,$strErr);
//       Die();
    }
}

// UPDATE
function CMN_M_CATEGORY_M_BatchUpd($UpdValue) {
    global $G_TODAY;

    $strSQL = "";
    $strSQL .= "UPDATE M_CATEGORY_M SET ";
    $strSQL .= "  BUTCH_RUN_YMD   = '".$G_TODAY."'";
    $strSQL .= " WHERE ";
    $strSQL .= "      CODE_L  = '".$UpdValue['CATE_L_CODE']."'";
    $strSQL .= "  AND CODE_M  = '".$UpdValue['CATE_M_CODE']."'";

    $Result = Mysql_Query($strSQL);

//CMN_DebugPrint("*CATE_L_CODE  ".$UpdValue['CATE_L_CODE']);
//CMN_DebugPrint("*CATE_M_CODE  ".$UpdValue['CATE_M_CODE']);

    if(!$Result){
        $strErr = 'CMN_M_CATEGORY_M_BatchUpd : '.Mysql_Error().'::'.$strSQL;
        LOG_OutPut(LOG_ERR_SQL,$strErr);
//       Die();
    }

}

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

