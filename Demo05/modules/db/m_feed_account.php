<?php
//-----------------------------------------
//-----------------------------------------
class db_m_feed_account {
    private $id;
    private $name;
    private $url;
    private $board_id;
    private $make_ptn;
    private $feed_date;
    private $update_date;


    private $tbl_name    = " m_feed_account";
    private $tbl_columns = " id,name,url,board_id, make_ptn, feed_date, update_date";

    //-----------------------------------------
    //変数クリア
    //-----------------------------------------
    function __construct() {
        global $G_TODAY;

        $this->id           = "";
        $this->name         = "";
        $this->url          = "";
        $this->board_id       = "";
        $this->make_ptn     = "";
        $this->feed_date    = "";
        $this->update_date  = "";
    }

    //データ・セット
    function set_id($val){
        $this->id  = $val;
    }
    function set_name($val){
        $this->name  = $val;
    }
    function set_url($val){
        $this->url  = $val;
    }
    function set_board_id($val){
        $this->board_id  = $val;
    }
    function set_make_ptn($val){
        $this->make_ptn  = $val;
    }
    function set_feed_date($val){
        $this->feed_date  = $val;
    }
    function set_update_date($val){
        $this->update_date  = $val;
    }

    //データ・返還
    function get_id(){
        return $this->id;
    }
    function get_name(){
        return $this->name;
    }
    function get_url(){
        return $this->url;
    }
    function get_board_id(){
        return $this->board_id;
    }
    function get_make_ptn(){
        return $this->make_ptn;
    }
    function get_feed_date(){
        return $this->feed_date;
    }



    //-----------------------------------------
    //-----------------------------------------
    function upd_feed_date(){
        global $G_MY_SQLI;
        
        //Debug情報をセット
        $fcName = $this->tbl_name." upd_feed_date";

        try{           //
            $strSQL  = "";
            $strSQL  = $strSQL . "UPDATE ".$this->tbl_name;
            $strSQL  = $strSQL . " SET  feed_date = '".$this->feed_date."'";
            $strSQL  = $strSQL . " WHERE id = '".$this->id."'";

            //Debug
            //echo $strSQL;

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
/*
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
*/
    //-----------------------------------------
    //-----------------------------------------
/*
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
*/
    //-----------------------------------------
    //  duplicate_insert
    //  存在しない場合は Insert
    //  既に存在する場合は無視
    //-----------------------------------------
/*
    function duplicate_insert (){
        global $G_MY_SQLI;
        
        //Debug情報をセット
        $fcName = "duplicate_insert";

        try{           //
            $strSQL  = "";
            $strSQL  = $strSQL . "INSERT INTO";
            $strSQL  = $strSQL . " m_board ";
            $strSQL  = $strSQL . "SELECT ";
            $strSQL  = $strSQL . " '".$this->board_id."'";
            $strSQL  = $strSQL . ",'".$this->board_name."'";
            $strSQL  = $strSQL . ",'".$this->board_url."'";
            $strSQL  = $strSQL . ", ".$this->sort_no." ";
            $strSQL  = $strSQL . ",'".$this->update_date."'";
            $strSQL  = $strSQL . " FROM";
            $strSQL  = $strSQL . "   DUAL";
            $strSQL  = $strSQL . " WHERE";
            $strSQL  = $strSQL . "      NOT EXISTS(";
            $strSQL  = $strSQL . "          SELECT";
            $strSQL  = $strSQL . "           'X' ";
            $strSQL  = $strSQL . "          FROM ";
            $strSQL  = $strSQL . "           m_board";
            $strSQL  = $strSQL . "          WHERE";
            $strSQL  = $strSQL . "            board_id = '".$this->board_id."'";
            $strSQL  = $strSQL . "  ";
            $strSQL  = $strSQL . " );";

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
*/

    //-----------------------------------------
    //-----------------------------------------
    function select_all($order_mode = null){
        global $G_MY_SQLI;
        $func_name  = $this->tbl_name."select_all";

        try{

            if($order_mode == null){
                $order_mode = 0;
            }

            //全検索
            $strSQL  = "";
            $strSQL  = $strSQL."SELECT  ";
            $strSQL  = $strSQL.$this->tbl_columns;
            $strSQL  = $strSQL." FROM ";
            $strSQL  = $strSQL." ".$this->tbl_name;

            $strSQL  = $strSQL." ORDER BY  id";

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
/*
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
*/

    //-----------------------------------------
    //-----------------------------------------
/*
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
*/
    //-----------------------------------------
    // sort_no_reset
    //-----------------------------------------
/*
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
*/

    //-----------------------------------------
    // sort_no_upd
    //-----------------------------------------
/*
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
*/

}

?>
