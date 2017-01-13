<?php
    require_once 'modules/require.php';


    //初期化
    $G_HTML_TITLE = "DEMO 01 TOP PAGE";
    $G_HTML_STYLESHEET = NULL;

//    require_once 'init.php';
    fcWriteHmtlHeader();

    fcGetThreadList();

    fcWriteThread();
/*
    $objSmarty->assign('tpl_name_head','head.tpl');
    $objSmarty->assign('tpl_name_main','home/main.tpl');

    $arrCss             = array($G_DIR_ROOT.'data/style/default/css/import.css'
                               ,'http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/'.JQUERY_THEME.'/jquery-ui.css');
    $arrJs              = array('http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js'
                               ,'http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js'
                               ,'http://ajax.googleapis.com/ajax/libs/jqueryui/1/i18n/jquery.ui.datepicker-ja.min.js');
    $arrSerchDayParam   = array('showButtonPanel: true'
                               ,',dateFormat: "yy/mm/dd"'
                               ,',minDate:    "d"'
                               ,',showAnim:         "fadeIn"'
                                );

*/
?>


