<?php
//-----------------------------------------
//-----------------------------------------
class db_m_board {
    private $board_id;
    private $board_name;
    private $board_url;
    private $dat_url;
    private $sort_no;
    private $update_date;

    private $tbl_name    = "m_board";
    private $tbl_columns = " board_id, board_name, board_url, dat_url, sort_no, update_date";

    const sort_no_default = 99999;

    //-----------------------------------------
    //変数クリア
    //-----------------------------------------
    function init(){
        global $G_TODAY;

        $this->board_id        = "";
        $this->board_name      = "";
        $this->board_url       = "";
        $this->dat_url         = "";
        $this->sort_no         = self::sort_no_default;
        $this->update_date     = $G_TODAY;

    }

    function __construct() {
        $this->init();
    }

    function set_board_id($val){
        $this->board_id = $val;
    }
    function set_board_name($val){
        $this->board_name  = $val;
    }
    function set_board_url($val){
        $this->board_url  = $val;
    }
    function set_dat_url($val){
        $this->dat_url  = $val;
    }
    function set_sort_no($val){
        $this->sort_no  = $val;
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
            $strSQL  = $strSQL . " '".$this->board_id."'";
            $strSQL  = $strSQL . ",'".$this->board_name."'";
            $strSQL  = $strSQL . ",'".$this->board_url."'";
            $strSQL  = $strSQL . ",'".$this->dat_url."'";
            $strSQL  = $strSQL . ", ".$this->sort_no." ";
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
            $strSQL  = $strSQL . "            board_id = '".$this->board_id."'";
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
