<?php
//-----------------------------------------
//-----------------------------------------
class db_d_thread {
    private $board_id;
    private $board_name;
    private $thread_id;
    private $thread_name;
    private $thread_date;
    private $res_cnt;
    private $dat_url;
    private $update_date;

    //-----------------------------------------
    //変数クリア
    //-----------------------------------------
    function init(){
        global $G_TODAY;

        $this->board_id = "";
        $this->board_name = "";
        $this->thread_id = "";
        $this->thread_name = "";
        $this->thread_date = "";
        $this->res_cnt = "";
        $this->dat_url = "";
        $this->update_date = $G_TODAY;
    }
    //-----------------------------------------
    //変数セット関数群
    //-----------------------------------------
    //
    function set_board_id($value){
        $this->board_id = $value;
    }
    //
    function set_board_name($value){
        $this->board_name = $value;
    }
    //
    function set_thread_id($value){
        $this->thread_id = $value;
    }
    //
    function set_thread_name($value){
        $this->thread_name = $value;
    }
    function set_thread_date($value){
        $this->thread_date = $value;
    }
    //
    function set_res_cnt($value){
        $this->res_cnt = $value;
    }
    //
    function set_dat_url($value){
        $this->dat_url = $value;
    }

    //-----------------------------------------
    //-----------------------------------------
    function truncate(){
        global $G_MY_SQLI;
        
        //Debug情報をセット
        $fcName = "d_thread truncate";
        
        try{
            //全削除
            $strSQL  = "TRUNCATE TABLE d_thread";

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$fcName.' : '.$G_MY_SQLI->connect_errno().'<br>'.$strSQL;
               print $strErr;
//                Die();
            }

        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$fcName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
        }
    }

    //-----------------------------------------
    // 主キーで削除
    //-----------------------------------------
    function del_with_key($board_id,$thread_id){
        global $G_MY_SQLI;
        
        //Debug情報をセット
        $fcName = "d_thread del_with_key";
        
        try{
            //全削除
            $strSQL  = "";
            $strSQL  = $strSQL."DELETE FROM d_thread ";
            $strSQL  = $strSQL."WHERE ";
            $strSQL  = $strSQL."     board_id  = '".$board_id."'";
            $strSQL  = $strSQL." and thread_id = '".$thread_id."'";

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$fcName.' : '.$G_MY_SQLI->connect_errno().'<br>'.$strSQL;
               print $strErr;
//                Die();
            }

        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$fcName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
        }
    }

    //-----------------------------------------
    // 板IDで削除
    //-----------------------------------------
    function del_with_board_id($board_id){
        global $G_MY_SQLI;
        
        //Debug情報をセット
        $fcName = "d_thread del_with_board_id";
        
        try{
            //全削除
            $strSQL  = "";
            $strSQL  = $strSQL."DELETE FROM d_thread ";
            $strSQL  = $strSQL."WHERE ";
            $strSQL  = $strSQL."     board_id  = '".$board_id."'";

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$fcName.' : '.$G_MY_SQLI->connect_errno().'<br>'.$strSQL;
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
        $fcName = "d_thread insert";

        try{
            //
            $strSQL  = "INSERT INTO d_thread VALUES(";
            $strSQL  = $strSQL . " '".$this->board_id."'";
            $strSQL  = $strSQL . ",'".DB_INS_STR_CONV($this->board_name)."'";
            $strSQL  = $strSQL . ",'".$this->thread_id."'";
            $strSQL  = $strSQL . ",'".DB_INS_STR_CONV($this->thread_name)."'";
            $strSQL  = $strSQL . ",'".$this->thread_date."'";
            $strSQL  = $strSQL . ",'".$this->res_cnt."'";
            $strSQL  = $strSQL . ",'".$this->dat_url."'";
            $strSQL  = $strSQL . ",'".$this->update_date."'";
            $strSQL  = $strSQL . ");";

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
    function select_with_board_id($board_id){
        global $G_MY_SQLI;
        static $FuncName  = "d_thread select_with_board_id";
        try{
            //全検索
            $strSQL  = "";
            $strSQL  = $strSQL."SELECT  ";
            $strSQL  = $strSQL." board_id";
            $strSQL  = $strSQL.",board_name";
            $strSQL  = $strSQL.",thread_id";
            $strSQL  = $strSQL.",thread_name";
            $strSQL  = $strSQL.",thread_date";
            $strSQL  = $strSQL.",LEFT(thread_date,10)  thread_date_ymd";
            $strSQL  = $strSQL.",res_cnt";
            $strSQL  = $strSQL.",dat_url";
            $strSQL  = $strSQL.",update_date";
            $strSQL  = $strSQL." FROM ";
            $strSQL  = $strSQL."  d_thread";
            $strSQL  = $strSQL." WHERE ";
            $strSQL  = $strSQL."   board_id = '".$board_id."'";
//            $strSQL  = $strSQL." ORDER BY thread_date desc, res_cnt desc";
            $strSQL  = $strSQL." ORDER BY LEFT(thread_date,10) desc, res_cnt desc";

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$FuncName.' : '.$G_MY_SQLI->connect_errno().'<br>'.$strSQL;
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
    function select_with_key($board_id,$thread_id){
        global $G_MY_SQLI;
        static $FuncName  = "d_thread select_with_key";
        try{
            //全検索
            $strSQL  = "";
            $strSQL  = $strSQL."SELECT  ";
            $strSQL  = $strSQL." board_id";
            $strSQL  = $strSQL.",board_name";
            $strSQL  = $strSQL.",thread_id";
            $strSQL  = $strSQL.",thread_name";
            $strSQL  = $strSQL.",thread_date";
            $strSQL  = $strSQL.",res_cnt";
            $strSQL  = $strSQL.",dat_url";
            $strSQL  = $strSQL.",update_date";
            $strSQL  = $strSQL." FROM ";
            $strSQL  = $strSQL."  d_thread";
            $strSQL  = $strSQL." WHERE ";
            $strSQL  = $strSQL."      board_id  = '".$board_id."'";
            $strSQL  = $strSQL." and  thread_id = '".$thread_id."'";
            $strSQL  = $strSQL." ORDER BY  res_cnt desc";

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$FuncName.' : '.$G_MY_SQLI->connect_errno().'<br>'.$strSQL;
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
}

?>
