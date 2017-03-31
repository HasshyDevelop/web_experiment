<?php
//-----------------------------------------
//-----------------------------------------
class db_d_task_m_schedule {
    //d_task
    private $task_id;
    private $task_schedule_no;

    //m_schedule
    private $schedule_no;
    private $exec_id;
    private $memo;
    private $general_col01;
    private $general_col02;
    private $general_col03;
    private $general_col04;
    private $general_col05;

    private $update_date;

    private $tbl_name    = " d_ranking";
//    private $tbl_columns = " board_id, thread_id, time_key, thread_name, max_rank, point, read_url, dat_url, update_date";
    private $tbl_columns = " board_id, thread_id, time_key, max_rank, point, read_url, dat_url, update_date";

    //-----------------------------------------
    //変数クリア
    //-----------------------------------------
    function __construct() {
        global $G_TODAY;

        $this->init();
    }
    function init(){
        global $G_TODAY;

        $this->task_id          = "";
        $this->task_schedule_no = "";

        $this->update_date  = $G_TODAY;
    }

    function set_task_id($val){
        $this->task_id       = $val;
    }
    function set_task_schedule_no($val){
        $this->task_schedule_no    = $val;
    }


    function set_time_key($val){
        $this->time_key    = $val;
    }
//    function set_thread_name($val){
//        $this->thread_name    = $val;
//    }
    function set_max_rank($val){
        $this->max_rank        = $val;
    }
    function set_point($val){
        $this->point        = $val;
    }
    function set_read_url($val){
        $this->read_url    = $val;
    }
    function set_dat_url($val){
        $this->dat_url    = $val;
    }
    function set_update_date($val){
       $this->update_date  = $val;
    }

    //-----------------------------------------
    //-----------------------------------------
    function select_task($id){
        global $G_MY_SQLI;
        $func_name  = "select_task";

        try{
            //全検索
            $strSQL  = "";
            $strSQL  = $strSQL."SELECT * FROM d_task WHERE id = '".$id."'";
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

    function insert_task(){
        global $G_MY_SQLI;
        
        //Debug情報をセット
        $fcName = "insert_task";

        try{           //
            $strSQL  = "";
            $strSQL  = $strSQL . "INSERt INTO ";
            $strSQL  = $strSQL . " d_task ";
            $strSQL  = $strSQL . " VALUES ( ";
            $strSQL  = $strSQL . "  '".$this->task_id."'";
            $strSQL  = $strSQL . " , ".$this->task_schedule_no;
            $strSQL  = $strSQL . " ,'".$this->update_date."'";
            $strSQL  = $strSQL . " )";

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

    function upd_task_schedule($schedule_no){
        global $G_MY_SQLI;
        
        //Debug情報をセット
        $fcName = "insert_task";

        try{           //
            $strSQL  = "";
            $strSQL  = $strSQL . "UPDATE ";
            $strSQL  = $strSQL . " d_task ";
            $strSQL  = $strSQL . " SET  ";
            $strSQL  = $strSQL . "  schedule_no = ".$schedule_no;
            $strSQL  = $strSQL . " ,update_date = '".$this->update_date."'";
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
    function select_schedule_with_no($schedule_no){
        global $G_MY_SQLI;

        $func_name  = "select_schedule";
        try{
            //全検索
            $strSQL  = "";
            $strSQL  = $strSQL."SELECT  ";
            $strSQL  = $strSQL."  schedule_no, exec_id, memo, general_col01, general_col02";
            $strSQL  = $strSQL." ,general_col03, general_col04, general_col05";
            $strSQL  = $strSQL." FROM ";
            $strSQL  = $strSQL."  m_schedule "; 
            $strSQL  = $strSQL." WHERE schedule_no = ".$schedule_no ;
//            $strSQL  = $strSQL." ORDER BY schedule_no";

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
