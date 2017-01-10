<?php
    require_once CMN_REALDIR . 'config.php';
    require_once CMN_REALDIR . 'global.php';
    require_once FNC_REALDIR . 'cmn.php';
    require_once FNC_REALDIR . 'log.php';
    require_once FNC_REALDIR . 'bat.php';
    require_once FNC_REALDIR . 'fuc_home.php';
    require_once FNC_REALDIR . 'fuc_search.php';


/*
if (SC_Display_Ex::detectDevice() == DEVICE_TYPE_MOBILE) {
    // resize_image.phpは除外
    if (stripos($_SERVER['REQUEST_URI'], ROOT_URLPATH . 'resize_image.php') === FALSE) {
        $objMobile = new SC_Helper_Mobile_Ex();
        $objMobile->sfMobileInit();
    }
}
*/

