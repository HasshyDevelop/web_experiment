<?php
//-----------------------------------------
//-----------------------------------------
class db_m_board {
    private $board_id;
    private $board_name;
    private $board_url;
    private $sort_no;
    private $update_date;

    private $tbl_columns = " board_id, board_name, board_url, sort_no, update_date";

    const sort_no_default = 99999;

    //-----------------------------------------
    //変数クリア
    //-----------------------------------------
    function init(){
        global $G_TODAY;

        $this->board_id        = "";
        $this->board_name      = "";
        $this->board_url       = "";
        $this->sort_no         = self::sort_no_default;
        $this->update_date     = $G_TODAY;

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

    //-----------------------------------------
    //-----------------------------------------
    function re_create_with_sort_no(){

        $sort_result    = $this->select_sortno(ODR_SORT);

        $arrID = array();
        $arrNo = array();

        //現在のソート番号を退避
        $cnt = 0;
        while ($row = $sort_result ->fetch_assoc()) {
            $arrID[$cnt] = $row['board_id'];
            $arrNo[$cnt] = $row['sort_no'];
            $cnt++;
        }

        //テーブルクリア
        $this->re_create();

        //退避しておいたソート番号を戻す
        for($cnt=0; $cnt<count($arrID); $cnt++){
            //print $arrID[$cnt]."\n";
            $this->sort_no_upd($arrID[$cnt], $arrNo[$cnt]);
        }

    }

    //-----------------------------------------
    //-----------------------------------------
    function re_create(){
        global $G_MY_SQLI;
        
        //Debug情報をセット
        $fcName = "m_board re_create";

        try{
            //板一覧を読み込む
            $html=file_get_contents(URL_BBSALL);
            //UTF-8に変換
            $html=mb_convert_encoding($html,'utf8','sjis-win');
            //リンクを配列に入れる
            preg_match_all('/<A HREF=.*>.*<\/A>/',$html,$links);

            //多次元配列をシングルに
            $links=$links[0];

            //2ch.scのリンクを抽出する
            $i=0;
            foreach($links as $link){
                if(preg_match('{<A HREF=http:\/\/(.*).2ch.sc\/(.*)\/>}',$link)){
                    //URL部分とリンクの文字を取得　$res[$i][0]にURL　$res[$i][1]に板名
                    if(preg_match_all('/<A HREF=(\S*)>(.*)<\/A>/',$link,$match,PREG_SET_ORDER)){
                        $res[$i][0]=$match[0][1];
                        $res[$i][1]=$match[0][2];
                        $i++;
                    }
                }
            }

            //テーブルをクリア
            $this->truncate();

            //各要素を取得
            foreach($res as $link){
                //変数初期化
                $this->init();

                $name=$link[1];//板名
                $url=$link[0];//URL

                //板IDだけを独立して取得
                preg_match('{2ch.sc/(.*)/$}',$url,$ch);
                $id=$ch[1];

                print 'ID：'.$id.'&#13;';
                print 'Name：'.$name.'&#13;';
                print 'URL：'.$url.'&#13;';

                $this->board_id        = $id;
                $this->board_name      = $name;
                $this->sort_no         = self::sort_no_default;
                $this->board_url       = $url;

                //DB 更新
                $this->duplicate_insert();

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
