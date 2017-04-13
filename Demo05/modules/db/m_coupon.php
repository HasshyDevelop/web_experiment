<?php
//-----------------------------------------
//-----------------------------------------
class db_m_coupon {
    private $coupon_id;
    private $coupon_area;
    private $coupon_site;
    private $coupon_url;
    private $coupon_title;
    private $coupon_summary;
    private $coupon_addr;
    private $coupon_access;
    private $coupon_teika;
    private $coupon_kakaku;
    private $coupon_shop;
    private $coupon_photo;
    private $coupon_lat;
    private $coupon_lng;
    private $coupon_untilldatetime;
    private $coupon_max;
    private $coupon_sold;
    private $priority;
    private $coupon_site_url;
    private $category_type;
    private $category_name;
    private $site_code;
    private $update_date;

    private $tbl_name    = "m_coupon";
//    private $tbl_columns = " board_id, board_name, board_url, read_url, dat_url, sort_no, update_date";

    const sort_no_default = 99999;

    //-----------------------------------------
    //変数クリア
    //-----------------------------------------
    function init(){
        global $G_TODAY;
        $this->coupon_id = "";
        $this->coupon_area = "";
        $this->coupon_site = "";
        $this->coupon_url = "";
        $this->coupon_title = "";
        $this->coupon_summary = "";
        $this->coupon_addr = "";
        $this->coupon_access = "";
        $this->coupon_teika = "";
        $this->coupon_kakaku = "";
        $this->coupon_shop = "";
        $this->coupon_photo = "";
        $this->coupon_lat = "";
        $this->coupon_lng = "";
        $this->coupon_untilldatetime = "";
        $this->coupon_max = "";
        $this->coupon_sold = "";
        $this->priority = "";
        $this->coupon_site_url = "";
        $this->category_type = "";
        $this->category_name = "";
        $this->site_code = "";
        $this->update_date     = $G_TODAY;
    }

    function __construct() {
        $this->init();
    }

    function set_coupon_id($val){
        $this->coupon_id = $val;
    }

    function set_coupon_area($val){
        $this->coupon_area = $val;
    }

    function set_coupon_site($val){
        $this->coupon_site = $val;
    }

    function set_coupon_url($val){
        $this->coupon_url = $val;
    }

    function set_coupon_title($val){
        $this->coupon_title = $val;
    }

    function set_coupon_summary($val){
        $this->coupon_summary = $val;
    }

    function set_coupon_addr($val){
        $this->coupon_addr = $val;
    }

    function set_coupon_access($val){
        $this->coupon_access = $val;
    }

    function set_coupon_teika($val){
        $this->coupon_teika = $val;
    }

    function set_coupon_kakaku($val){
        $this->coupon_kakaku = $val;
    }

    function set_coupon_shop($val){
        $this->coupon_shop = $val;
    }

    function set_coupon_photo($val){
        $this->coupon_photo = $val;
    }

    function set_coupon_lat($val){
        $this->coupon_lat = $val;
    }

    function set_coupon_lng($val){
        $this->coupon_lng = $val;
    }

    function set_coupon_untilldatetime($val){
        $this->coupon_untilldatetime = $val;
    }

    function set_coupon_max($val){
        $this->coupon_max = $val;
    }

    function set_coupon_sold($val){
        $this->coupon_sold = $val;
    }

    function set_priority($val){
        $this->priority = $val;
    }

    function set_coupon_site_url($val){
        $this->coupon_site_url = $val;
    }

    function set_category_type($val){
        $this->category_type = $val;
    }

    function set_category_name($val){
        $this->category_name = $val;
    }

    function set_site_code($val){
        $this->site_code = $val;
    }

    //-----------------------------------------
    //-----------------------------------------
    function truncate(){
        global $G_MY_SQLI;
        
        //Debug情報をセット
        $fcName = "m_board truncate";
        
        try{
            //全削除
            $strSQL  = "TRUNCATE TABLE m_board";

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$fcName.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
               print $strErr;
//                Die();
            }

        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$fcName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
        }
    }

    //-----------------------------------------
    //-----------------------------------------
    function insert(){
        global $G_MY_SQLI;
        
        //Debug情報をセット
        $fcName = "m_board insert";

        try{
            //
            $strSQL  = "INSERT INTO m_board VALUES(";
            $strSQL  = $strSQL . " '".$this->board_id."'";
            $strSQL  = $strSQL . ",'".$this->board_name."'";
            $strSQL  = $strSQL . ",'".$this->board_url."'";
            $strSQL  = $strSQL . ", ".$this->sort_no." ";
            $strSQL  = $strSQL . ",'".$this->update_date."'";
            $strSQL  = $strSQL . "); ";

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$fcName.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
               print $strErr;
//                Die();
            }

        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$fcName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
        }
    }

    //-----------------------------------------
    //-----------------------------------------
    function old_delete($delete_day){
        global $G_MY_SQLI;
        
        //Debug情報をセット
        $fcName = $this->tbl_name." old_delete";

        try{
            //
            $strSQL  = "DELETE FROM ".$this->tbl_name." ";
            $strSQL  = $strSQL . " WHERE left(coupon_untilldatetime,10) < '".$delete_day."'";

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$fcName.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
               print $strErr;
//                Die();
            }

        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$fcName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
        }
    }

    //-----------------------------------------
    //  duplicate_insert
    //  存在しない場合は Insert
    //  既に存在する場合は無視
    //-----------------------------------------
    function duplicate_insert (){
        global $G_MY_SQLI;
        
        //Debug情報をセット
        $fcName = $this->tbl_name." duplicate_insert";

        try{           //
            $strSQL  = "";
            $strSQL  = $strSQL . "INSERT INTO";
            $strSQL  = $strSQL . " ".$this->tbl_name;
            $strSQL  = $strSQL . " SELECT ";
            $strSQL  = $strSQL . " '".$this->coupon_id."'";
            $strSQL  = $strSQL . ",'".$this->coupon_area."'";
            $strSQL  = $strSQL . ",'".$this->coupon_site."'";
            $strSQL  = $strSQL . ",'".$this->coupon_url."'";
            $strSQL  = $strSQL . ",'".$this->coupon_title."'";
            $strSQL  = $strSQL . ",'".$this->coupon_summary."'";
            $strSQL  = $strSQL . ",'".$this->coupon_addr."'";
            $strSQL  = $strSQL . ",'".$this->coupon_access."'";
            $strSQL  = $strSQL . ",'".$this->coupon_teika."'";
            $strSQL  = $strSQL . ",'".$this->coupon_kakaku."'";
            $strSQL  = $strSQL . ",'".$this->coupon_shop."'";
            $strSQL  = $strSQL . ",'".$this->coupon_photo."'";
            $strSQL  = $strSQL . ",'".$this->coupon_lat."'";
            $strSQL  = $strSQL . ",'".$this->coupon_lng."'";
            $strSQL  = $strSQL . ",'".$this->coupon_untilldatetime."'";
            $strSQL  = $strSQL . ",'".$this->coupon_max."'";
            $strSQL  = $strSQL . ",'".$this->coupon_sold."'";
            $strSQL  = $strSQL . ",'".$this->priority."'";
            $strSQL  = $strSQL . ",'".$this->coupon_site_url."'";
            $strSQL  = $strSQL . ",'".$this->category_type."'";
            $strSQL  = $strSQL . ",'".$this->category_name."'";
            $strSQL  = $strSQL . ",'".$this->site_code."'";
            $strSQL  = $strSQL . ",'".$this->update_date."'";
            $strSQL  = $strSQL . " FROM";
            $strSQL  = $strSQL . "   DUAL";
            $strSQL  = $strSQL . " WHERE";
            $strSQL  = $strSQL . "      NOT EXISTS(";
            $strSQL  = $strSQL . "          SELECT";
            $strSQL  = $strSQL . "           'X' ";
            $strSQL  = $strSQL . "          FROM ";
            $strSQL  = $strSQL . "          ".$this->tbl_name;
            $strSQL  = $strSQL . "          WHERE";
            $strSQL  = $strSQL . "            coupon_id = '".$this->coupon_id."'";
            $strSQL  = $strSQL . "  ";
            $strSQL  = $strSQL . " );";

            //Debug
            //print $strSQL;

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$fcName.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
               print $strErr;
//                Die();
            }

        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$fcName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
        }
    }

    //-----------------------------------------
    //-----------------------------------------
    function select_all($order_mode = null){
        global $G_MY_SQLI;
        static $func_name  = "m_board select_all";
        try{

            if($order_mode == null){
                $order_mode = 0;
            }

            //全検索
            $strSQL  = "";
            $strSQL  = $strSQL."SELECT  ";
            $strSQL  = $strSQL.$this->tbl_columns;
            $strSQL  = $strSQL." FROM ";
            $strSQL  = $strSQL."  m_board";

            switch ($order_mode) {
                case ODR_SORT:
                    $strSQL  = $strSQL." ORDER BY  sort_no, board_id";
                    break;
                default:
                    $strSQL  = $strSQL." ORDER BY  board_id";
                    break;
            }

            //Debug
            //print $strSQL;

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$func_name.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
               print $strErr;
               //Die();
               return NULL;
            }

            return $result;

        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$FuncName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
            
            return NULL;
        }
    }

    //-----------------------------------------
    //-----------------------------------------
    function select_with_key($board_id = NULL){
        global $G_MY_SQLI;
        $func_name  = $this->tbl_name." select_with_key";
        try{

            //全検索
            $strSQL  = "";
            $strSQL  = $strSQL."SELECT  ";
            $strSQL  = $strSQL.$this->tbl_columns;
            $strSQL  = $strSQL." FROM ";
            $strSQL  = $strSQL."  ".$this->tbl_name;
            $strSQL  = $strSQL." WHERE  board_id != '' ";     //ダミー

            if($board_id != NULL){
                $strSQL  = $strSQL." AND  board_id = '".$board_id."'";
            }

            //Debug
            //print $strSQL;

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$func_name.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
               print $strErr;
               //Die();
               return NULL;
            }

            return $result;

        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$FuncName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
            
            return NULL;
        }
    }

    //-----------------------------------------
    //-----------------------------------------
    function select_no_sortno($order_mode){
        global $G_MY_SQLI;
        static $func_name  = "select_no_sortno";
        try{
            //全検索
            $strSQL  = "";
            $strSQL  = $strSQL."SELECT  ";
            $strSQL  = $strSQL.$this->tbl_columns;
            $strSQL  = $strSQL." FROM ";
            $strSQL  = $strSQL."  m_board";
            $strSQL  = $strSQL." WHERE ";
            $strSQL  = $strSQL."  sort_no = ".self::sort_no_default;
            switch ($order_mode) {
                case ODR_SORT:
                    $strSQL  = $strSQL." ORDER BY  sort_no, board_id";
                    break;
                default:
                    $strSQL  = $strSQL." ORDER BY  board_id";
                    break;
            }

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$func_name.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
               print $strErr;
               //Die();
               return NULL;
            }
            return $result;

        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$FuncName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
            
            return NULL;
        }
    }

    //-----------------------------------------
    //-----------------------------------------
    function select_sortno($order_mode){
        global $G_MY_SQLI;
        static $func_name  = "select_no_sortno";
        try{
            //全検索
            $strSQL  = "";
            $strSQL  = $strSQL."SELECT  ";
            $strSQL  = $strSQL.$this->tbl_columns;
            $strSQL  = $strSQL." FROM ";
            $strSQL  = $strSQL."  m_board";
            $strSQL  = $strSQL." WHERE ";
            $strSQL  = $strSQL."  sort_no <> ".self::sort_no_default;
            switch ($order_mode) {
                case ODR_SORT:
                    $strSQL  = $strSQL." ORDER BY  sort_no, board_id";
                    break;
                default:
                    $strSQL  = $strSQL." ORDER BY  board_id";
                    break;
            }

            //Debug
            //print $strSQL;

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$func_name.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
               print $strErr;
               //Die();
               return NULL;
            }
            return $result;

        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$FuncName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
            
            return NULL;
        }
    }

    //-----------------------------------------
    // sort_no_reset
    //-----------------------------------------
    function sort_no_reset (){
        global $G_MY_SQLI;
        
        //Debug情報をセット
        $fcName = "sort_no_reset";

        try{           //
            $strSQL  = "";
            $strSQL  = $strSQL . "UPDATE m_board SET sort_no = ".self::sort_no_default;

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$fcName.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
               print $strErr;
//                Die();
            }

        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$fcName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
        }
    }

    //-----------------------------------------
    // sort_no_upd
    //-----------------------------------------
    function sort_no_upd ($id, $sort_no){
        global $G_MY_SQLI;
        
        //Debug情報をセット
        $fcName = "sort_no_reset";

        try{           //
            $strSQL  = "";
            $strSQL  = $strSQL . "UPDATE m_board ";
            $strSQL  = $strSQL . " SET sort_no = ".$sort_no;
            $strSQL  = $strSQL . " WHERE ";
            $strSQL  = $strSQL . "   board_id = '".$id."'" ;

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$fcName.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
               print $strErr;
//                Die();
            }

        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$fcName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
        }
    }


}

?>
