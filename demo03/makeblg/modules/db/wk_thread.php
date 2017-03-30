<?php
//-----------------------------------------
//-----------------------------------------
class db_wk_thread {
    public $thread_id;
    public $thread_name;
    public $sort_cd;
    public $res_id;
    public $parent_res_id;
    public $post_name;
    public $post_mail;
    public $post_datetime;
    public $post_txt;
    public $disp_flg;
    public $update_date;

    private $tbl_name = "wk_thread";

    public $tbl_colums = "thread_id"
                        .",thread_name"
                        .",sort_cd"
                        .",res_id"
                        .",parent_res_id"
                        .",post_name"
                        .",post_mail"
                        .",post_datetime"
                        .",post_txt"
                        .",disp_flg"
                        .",update_date";

    //-----------------------------------------
    //変数クリア
    //-----------------------------------------
    function init(){
        global $G_TODAY;

        $this->thread_id        = "";
        $this->thread_name      = "";
        $this->sort_cd          = "";
        $this->res_id           = 0;
        $this->parent_res_id    = 0;
        $this->post_name        = "";
        $this->post_mail        = "";
        $this->post_datetime    = "";
        $this->post_txt         = "";
        $this->disp_flg         = 1;
        $this->update_date      = $G_TODAY;
    }

    //-----------------------------------------
    //-----------------------------------------
    function truncate(){
        global $G_MY_SQLI;
        static $FuncName  = "wk_thread truncate";
        try{
            //全削除
            $strSQL  = "TRUNCATE TABLE wk_thread";

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$FuncName.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
               print $strErr;
//                Die();
            }

        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$FuncName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
        }
    }

    //-----------------------------------------
    //-----------------------------------------
    function insert(){
        global $G_MY_SQLI;
        static $FuncName  = "wk_thread insert";
        try{
            //
            $strSQL  = "INSERT INTO wk_thread VALUES(";
            $strSQL  = $strSQL . " '".$this->thread_id."'";
            $strSQL  = $strSQL . ",'".$this->thread_name."'";
            $strSQL  = $strSQL . ",'".$this->sort_cd."'";
            $strSQL  = $strSQL . ",'".$this->res_id."'";
            $strSQL  = $strSQL . ",'".$this->parent_res_id."'";
            $strSQL  = $strSQL . ",'".$this->post_name."'";
            $strSQL  = $strSQL . ",'".$this->post_mail."'";
            $strSQL  = $strSQL . ",'".$this->post_datetime."'";
            $strSQL  = $strSQL . ",'".$this->post_txt."'";
            $strSQL  = $strSQL . ",'".$this->disp_flg."'";
            $strSQL  = $strSQL . ",'".$this->update_date."'";
            $strSQL  = $strSQL . ");";

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$FuncName.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
               print $strErr;
//                Die();
            }

        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$FuncName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
        }
    }

    //-----------------------------------------
    //-----------------------------------------
    function update_parent_res_id($thread_id,$res_id,$parent_res_id){
        global $G_MY_SQLI;
        static $FuncName  = "wk_thread update_parent_id";
        try{
            //全削除
            $strSQL  = "UPDATE wk_thread SET ";
            $strSQL  = $strSQL." parent_res_id = '".$parent_res_id."'";
            $strSQL  = $strSQL." WHERE";
            $strSQL  = $strSQL."       thread_id = '".$thread_id."'";
            $strSQL  = $strSQL."   and res_id    = '".$res_id."'";

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$FuncName.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
               print $strErr;
//                Die();
            }

        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$FuncName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
        }
    }

    //-----------------------------------------
    //-----------------------------------------
    function update_sort_cd($thread_id,$res_id,$sort_cd){
        global $G_MY_SQLI;
        static $FuncName  = "wk_thread update_sort_cd";
        try{
            //全削除
            $strSQL  = "UPDATE wk_thread SET ";
            $strSQL  = $strSQL." sort_cd = '".$sort_cd."'";
            $strSQL  = $strSQL." WHERE";
            $strSQL  = $strSQL."       thread_id = '".$thread_id."'";
            $strSQL  = $strSQL."   and res_id    = '".$res_id."'";

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$FuncName.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
               print $strErr;
//                Die();
            }

        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$FuncName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
        }
    }

    //-----------------------------------------
    //-----------------------------------------
    function select_disp(){
        global $G_MY_SQLI;
        $FuncName  = $this->tbl_name." select_disp";
        try{
            //
            $strSQL  = "";
            $strSQL  = $strSQL."SELECT  ";
            $strSQL  = $strSQL.$this->tbl_colums;
            $strSQL  = $strSQL." FROM ";
            $strSQL  = $strSQL." ".$this->tbl_name;
            $strSQL  = $strSQL." WHERE ";
            $strSQL  = $strSQL." disp_flg = 1";
            $strSQL  = $strSQL." AND thread_id = '".$this->thread_id."'";

            $strSQL  = $strSQL." ORDER BY  sort_cd";

            //Debug
            //echo $strSQL;

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$FuncName.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
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
    function select_res_data(){
        global $G_MY_SQLI;
        static $FuncName  = "wk_thread select_res_data";
        try{
            //
            $strSQL  = "";
            $strSQL  = $strSQL."SELECT  ";
            $strSQL  = $strSQL.$this->tbl_colums;
            $strSQL  = $strSQL." FROM ";
            $strSQL  = $strSQL." wk_thread";
            $strSQL  = $strSQL." WHERE ";
            $strSQL  = $strSQL." disp_flg = 1";
            $strSQL  = $strSQL." AND post_txt LIKE '%&gt;&gt;%'";
            $strSQL  = $strSQL." ORDER BY  parent_res_id, res_id";
//print $strSQL;

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$FuncName.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
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
    function select_no_disp(){
        global $G_MY_SQLI;
        static $FuncName  = "wk_thread select_disp";
        try{
            //
            $strSQL  = "";
//            $strSQL  = $strSQL."SELECT  lpad(res_id,".strlen(SORT_CD_DEF).",'0') as res_id";
            $strSQL  = $strSQL."SELECT  res_id";
            $strSQL  = $strSQL." FROM ";
            $strSQL  = $strSQL." wk_thread";
            $strSQL  = $strSQL." WHERE ";
            $strSQL  = $strSQL."       disp_flg  <> 1";
            $strSQL  = $strSQL."   AND thread_id = '".$this->thread_id."'";
            $strSQL  = $strSQL." ORDER BY  res_id";
//print $strSQL;

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$FuncName.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
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
    // 非表示設定　
    // 既に親が非表示の子を非表示設定にする
    //-----------------------------------------
    function hide_setting_no_parents($child_cd){
        global $G_MY_SQLI;
        static $FuncName  = "wk_thread hide_setting_txt";
        try {

            $wk_child_cd = str_pad($child_cd, 5, 0, STR_PAD_LEFT);

//print "DEBUG::".$wk_child_cd."<br>";

            //
            $strSQL  = "";
            $strSQL  = $strSQL."UPDATE wk_thread SET disp_flg = 0 ";
            $strSQL  = $strSQL." WHERE ";
            //1行目は強制出力
            $strSQL  = $strSQL."     res_id <> 1";
            $strSQL  = $strSQL." AND thread_id = '".$this->thread_id."'";
            $strSQL  = $strSQL." AND res_id <> ".$child_cd; //自分自身は対象外とするため
            $strSQL  = $strSQL." AND sort_cd LIKE '%".$wk_child_cd."%'";

//print $strSQL;

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$FuncName.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
               print $strErr;
               //Die();
               return NULL;
            }
//print "UPDATE ROWS ::".$G_MY_SQLI->affected_rows."<br>";
//            return $result;

        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$FuncName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
            
            return NULL;
        }
    }

    //-----------------------------------------
    // 表示データ件数の取得
    //-----------------------------------------
    function select_disp_cnt(){
        global $G_MY_SQLI;
        static $FuncName  = "wk_thread select_disp_cnt";
        try{
            //
            $strSQL  = "";
            $strSQL  = $strSQL."SELECT ";
            $strSQL  = $strSQL.$this->tbl_colums;
            $strSQL  = $strSQL." ,count(*) as disp_cnt";
            $strSQL  = $strSQL." FROM ";
            $strSQL  = $strSQL." wk_thread";
            $strSQL  = $strSQL." WHERE ";
            $strSQL  = $strSQL."     disp_flg = 1";
            $strSQL  = $strSQL." AND thread_id = '".$this->thread_id."'";
//print $strSQL;

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$FuncName.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
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
    // 非表示設定　メイン処理
    //-----------------------------------------
    function hide_setting(){
        static $FuncName  = "wk_thread hide_setting";
        try{
            //文字数で設定
            $this->hide_setting_txt();
            
            //最後はランダム
            $this->hide_setting_rdm();

        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$FuncName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
            
            return NULL;
        }
    }

    //-----------------------------------------
    // 非表示設定　
    // 短すぎ　長すぎのデータを非表示設定にする
    //-----------------------------------------
    function hide_setting_txt(){
        global $G_MY_SQLI;
        static $FuncName  = "wk_thread hide_setting_txt";
        try {
            //
            $strSQL  = "";
            $strSQL  = $strSQL."UPDATE wk_thread SET disp_flg = 0 ";
            $strSQL  = $strSQL." WHERE ";
            //1行目は強制出力
            $strSQL  = $strSQL." res_id <> 1";      
            
            $strSQL  = $strSQL." AND ";
            $strSQL  = $strSQL."    (";
//短い文字は許可してみる
//            $strSQL  = $strSQL."     CHAR_LENGTH(`post_txt`) < ".DEL_TXT_MIN;       //短い文字
//            $strSQL  = $strSQL."     OR ";
            $strSQL  = $strSQL."     CHAR_LENGTH(`post_txt`) > ".DEL_TXT_LNG;       //長い文字
            $strSQL  = $strSQL."    )";
            //レスが場合は対象外とする
            //$strSQL  = $strSQL." AND res_id NOT IN (";
            //$strSQL  = $strSQL."                    SELECT parent_res_id ";
            //$strSQL  = $strSQL."                      FROM wk_thread ";
            //$strSQL  = $strSQL."                     WHERE ";
            //$strSQL  = $strSQL."                            res_id <> 1 ";
            //$strSQL  = $strSQL."                        AND thread_id = '".$this->thread_id."'";
            //$strSQL  = $strSQL."                        AND disp_flg  = 1";
            //$strSQL  = $strSQL."                   )";

//print $strSQL;

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = '<b>SQL ERR </b>'.$FuncName.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
               print $strErr;
               //Die();
               return NULL;
            }

//            return $result;

        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$FuncName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
            
            return NULL;
        }
    }

    //-----------------------------------------
    // 非表示設定　
    // 短すぎ　長すぎのデータを非表示設定にする
    //-----------------------------------------
    function hide_setting_rdm_upd($dele_limit){
        global $G_MY_SQLI;
        static $FuncName  = "wk_thread hide_setting_rdm_upd";
        try {
            //
            $strSQL  = "";
            $strSQL  = $strSQL."UPDATE wk_thread SET disp_flg = 0 ";
            $strSQL  = $strSQL." WHERE ";
            $strSQL  = $strSQL."     res_id <> 1";
            $strSQL  = $strSQL." AND thread_id = '".$this->thread_id."'";
            $strSQL  = $strSQL." AND res_id  IN ";
            $strSQL  = $strSQL."              ( SELECT res_id FROM ";
            $strSQL  = $strSQL."                                ( SELECT res_id ";
            $strSQL  = $strSQL."                                    FROM wk_thread ";
            $strSQL  = $strSQL."                                   WHERE ";
            $strSQL  = $strSQL."                                        res_id <> 1 ";
            $strSQL  = $strSQL."                                    AND thread_id = '".$this->thread_id."'";
            $strSQL  = $strSQL."                                    AND disp_flg  = 1";

            $strSQL  = $strSQL."                                    AND res_id NOT IN (";
            $strSQL  = $strSQL."                                                        SELECT parent_res_id ";
            $strSQL  = $strSQL."                                                          FROM wk_thread ";
            $strSQL  = $strSQL."                                                         WHERE ";
            $strSQL  = $strSQL."                                                                res_id <> 1 ";
            $strSQL  = $strSQL."                                                            AND thread_id = '".$this->thread_id."'";
            $strSQL  = $strSQL."                                                            AND disp_flg  = 1";
            $strSQL  = $strSQL."                                                      )";

            $strSQL  = $strSQL."                                    ORDER BY RAND() ";
            $strSQL  = $strSQL."                                    LIMIT ".$dele_limit;
            $strSQL  = $strSQL."                                 ) AS WK_TBL";
            $strSQL  = $strSQL."              )";

            if(!$result = $G_MY_SQLI->query($strSQL)){
                $strErr = '<b>SQL ERR </b>'.$FuncName.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
                print $strErr;
                //Die();
                return NULL;
            }
//print "UPDATE ROWS ::".$G_MY_SQLI->affected_rows."<br>";
            
        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$FuncName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
            
            return NULL;
        }
    }

    //-----------------------------------------
    // 非表示設定　
    // レスのないデータを適当に間引く
    //-----------------------------------------
    function hide_setting_rdm(){
        global $G_MY_SQLI;
        static $FuncName  = "wk_thread hide_setting_txt";
        try {
            $base_cnt = 100;
            //毎回同じ件数だとおかしいので適当に数字を足す
            $base_cnt += mt_rand(2,mt_rand(1,50));

//print "DEBUG STRAT <br>";
//print "thread_id : ".$this->thread_id."<br>";

            //DBの値を取得
            $result = $this->select_disp_cnt();
            while ($row = $result->fetch_assoc()) {
                $all_cnt = $row['disp_cnt'];
            }

            $delete_cnt = $all_cnt - $base_cnt;
            if($delete_cnt < 0){
                //基準値以下は終了
                return;
            }
//print "総件数::".$all_cnt."<br>";
//print "削除件数::".$delete_cnt."<br>";
//print "削除後予定件数::".$base_cnt."<br>";

            $this->hide_setting_rdm_upd($delete_cnt);

//DEBUG
            //DBの値を取得
            $result = $this->select_disp_cnt();
            while ($row = $result->fetch_assoc()) {
                $all_cnt = $row['disp_cnt'];
            }
//print "実件数::".$all_cnt."<br>";

        } catch (Exception $e) {
            $strErr = '<b>OTHER ERR </b>'.$FuncName.' : '.$e->getMessage().'<br>'.$strSQL;
            print $strErr;
            
            return NULL;
        }
    }
}

?>
