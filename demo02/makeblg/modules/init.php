<?php

    //DBへの接続
    $G_MY_SQLI = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
    // 接続状況チェック
    // mysqli_connect_errno : 直近の接続コールに関するエラーコードを返却
    if(mysqli_connect_errno()){
        // mysqli_connect_error : 直近のエラー内容を文字列で返却
        die('MYSQL CONNECT ERROR'.mysql_error());
    }

    if (!$G_MY_SQLI->set_charset("utf8")) {
//        printf("Error loading character set utf8: %s\n", $mysqli->error);
        exit();
    } else {
//        printf("Current character set: %s\n", $G_MY_SQLI->character_set_name());
    }
//    $G_MY_SQLI->query('SET NAMES utf8')){

    //システム日付
    getSysDate();
    //システムマスタ
//    CMN_GetM_SYS();

?>
