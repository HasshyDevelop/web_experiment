<?php
    require_once 'global.php';
    require_once 'config.php';

    //func
//    require_once 'func/fc_html_def.php';
    require_once 'fnc/fc_cmn.php';
//    require_once 'func/fc_test.php';


    //db
    require_once 'db/m_feed_account.php';

    //util
    require_once 'utl/utl_make_data.php';
    require_once 'utl/utl_markov.php';

//    require_once 'util/utl_thread.php';
//    require_once 'util/utl_cmn.php';


    //NOTE:init.php　は一番最後に呼ぶ事
    require_once 'init.php';
/*

    require_once FNC_REALDIR . 'cmn.php';
    require_once FNC_REALDIR . 'log.php';
    require_once FNC_REALDIR . 'bat.php';
    require_once FNC_REALDIR . 'fuc_home.php';
    require_once FNC_REALDIR . 'fuc_search.php';
*/

