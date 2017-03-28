<?php
//-----------------------------------------
//-----------------------------------------
class db_d_ranking {
    private $blg_id;
    private $thread_id;
    private $max_rank;
    private $point;
    private $update_date;

    private $tbl_name    = " d_ranking";
    private $tbl_columns = " blg_id, thread_id, max_rank, point, update_date";

    //-----------------------------------------
    //変数クリア
    //-----------------------------------------
    function __construct() {
        global $G_TODAY;

        $this->init();
    }
    function init(){
        global $G_TODAY;

        $this->blg_id       = "";
        $this->thread_id    = "";
        $this->max_rank    = "";
        $this->point        = "";
        $this->update_date  = $G_TODAY;
    }

    function set_blg_id($val){
        $this->blg_id       = $val;
    }
    function set_thread_id($val){
        $this->thread_id    = $val;
    }
    function set_max_rank($val){
        $this->max_rank        = $val;
    }
    function set_point($val){
        $this->point        = $val;
    }
    function set_update_date($val){
       $this->update_date  = $val;
    }

    //-----------------------------------------
    //-----------------------------------------

    function truncate(){
        global $G_MY_SQLI;
        
        //Debug情報をセット
        $fcName = $this->tbl_name."truncate";
         
        try{
            //全削除
            $strSQL  = "TRUNCATE TABLE ".$this->tbl_name;
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
    function ins_duplicate_upd(){
        global $G_MY_SQLI;
        
        //Debug情報をセット
        $fcName = $this->tbl_name." insert";

        try{
            //
            $strSQL  = "INSERT INTO ".$this->tbl_name." (".$this->tbl_columns.") VALUES (";
            $strSQL  = $strSQL . " '".$this->blg_id."'";
            $strSQL  = $strSQL . ",'".$this->thread_id."'";
            $strSQL  = $strSQL . ",'".$this->max_rank."'";
            $strSQL  = $strSQL . ",'".$this->point."'";
            $strSQL  = $strSQL . ",'".$this->update_date."'";
            $strSQL  = $strSQL . ") ";
            $strSQL  = $strSQL . " on duplicate key update ";
            $strSQL  = $strSQL . "  blg_id    = '".$this->blg_id."'";
            $strSQL  = $strSQL . " ,thread_id = '".$this->thread_id."'";
            $strSQL  = $strSQL . " ,max_rank = ( ";
            $strSQL  = $strSQL . "         CASE WHEN max_rank < ".$this->max_rank." THEN max_rank";
            $strSQL  = $strSQL . "         ELSE ".$this->max_rank." END";
            $strSQL  = $strSQL . "              )";
            $strSQL  = $strSQL . " ,point = point+".$this->point."";


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
    function old_data_delete(){
        global $G_MY_SQLI;
        
        //Debug情報をセット
        $fcName = $this->tbl_name." old_data_delete";

        try{
            //
            $strSQL  = "DELETE FROM ".$this->tbl_name;
            $strSQL  = $strSQL . " WHERE ";
            $strSQL  = $strSQL . " update_date < ";
            $strSQL  = $strSQL . " (DATE_FORMAT(NOW() -INTERVAL 7 DAY , '%Y-%m-%d' ) )";

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

/*
            switch ($order_mode) {
                case ODR_SORT:
                    $strSQL  = $strSQL." ORDER BY  sort";
                    break;
                default:
                    $strSQL  = $strSQL." ORDER BY  sort";
                    break;
            }
*/
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
