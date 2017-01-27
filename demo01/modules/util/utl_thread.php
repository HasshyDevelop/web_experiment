<?php
//-----------------------------------------
//-----------------------------------------

class utl_thread {
    private $thread_id;
    private $thread_name;
    private $dat_url;

    private $wk_sort_code = array();

    //-----------------------------------------
    //変数クリア
    //-----------------------------------------
    function init(){
        $this->thread_id    = "";
        $this->thread_name  = "";
        $this->dat_url      = "";
    }
    //
    function set_thread_id($value){
        $this->thread_id = $value;
    }
    //
    function set_thread_name($value){
        $this->thread_name = $value;
    }
    //
    function set_dat_url($value){
        $this->dat_url = $value;
    }
    //-----------------------------------------
    //-----------------------------------------
    //--
    function sort_code_init(){
        for($i=0;$i<10;$i++){
            $this->wk_sort_code[$i] = SORT_CD_DEF;
        }
    }
    //--
    function sort_code_add($val){
        $arr_cnt = count($this->wk_sort_code)-1;

        while ($arr_cnt != 0){
            $this->wk_sort_code[$arr_cnt] = $this->wk_sort_code[$arr_cnt-1];
            $arr_cnt--;
        }
        $this->wk_sort_code[0] = substr(SORT_CD_DEF.$val,-5);
    }
    //--
    function sort_code_get(){
        $result = "";

        for($i=0;$i<count($this->wk_sort_code);$i++){
            if($i == 0){
                $result = $this->wk_sort_code[$i];
            } else {
                $result = $result."-".$this->wk_sort_code[$i];
            }
        }
        return $result;
    }
    //--
    function get_parents_id_from_sort_cd($arr_val) {
        $arr_result = explode('-', $arr_val);
        return $arr_result[0];
    }

    //-----------------------------------------
    //-----------------------------------------
    function make_data(){
        global $G_TODAY;

        //wk_thread オブジェクトの作成
        $dbObj = new db_wk_thread();
        //スレッドデータクリア
        $dbObj->truncate();

        //DATファイル取得
        $html=file_get_contents($this->dat_url);
        //UTFに変換
        $html=mb_convert_encoding($html,'utf8','sjis-win');
        
        //******************************
        //余計な文字を削除
        //******************************
        //余計な</b><b>が入っている場合があるので、一つずつ削除
        $html=str_replace('<b>','',$html);
        $html=str_replace('</b>','',$html);
        //アンカーのリンクは邪魔なので外す。@はデリミタ
        $html=preg_replace('@<a(?:>| [^>]*?>)(.*?)</a>@s','$1',$html);

        //******************************
        //各要素をばらす
        //******************************
        //行ごとになっている各レスを独立
        preg_match_all('/(.*?)\n/u',$html,$lines);

        $i=1;
        foreach($lines[0] as $line){
            //クラスプロパティ初期化
            $dbObj->init();

            //名前、日時、ID、書き込みを各要素別にバラす
            preg_match_all('/(.*?)<>/u',$line,$elements);

            //foreachの中にforeachを入れたら、なぜか文字化けするので多次元配列に
            $res_2ch            = array($elements[0]);
            $name_2ch           = str_replace('<>','',$res_2ch[0][0]);   //名前
            $mail_2ch           = str_replace('<>','',$res_2ch[0][1]);   //メルアド
            $datetime_id_2ch    = str_replace('<>','',$res_2ch[0][2]);   //日時
            //本文分割
            $text_2ch           = str_replace(' <>','',$res_2ch[0][3]);
            $text_2ch           = DB_INS_STR_CONV($text_2ch);

            //クラス変数にセット
            $this->sort_code_init();
            $this->sort_code_add($i);

            $dbObj->thread_id     = $this->thread_id;
            $dbObj->thread_name   = $this->thread_name;
            $dbObj->sort_cd       = $this->sort_code_get();
            $dbObj->res_id        = $i;
//            $dbObj->parent_res_id = $i;
            $dbObj->parent_res_id = 0;
            $dbObj->post_name     = $name_2ch;
            $dbObj->post_mail     = $mail_2ch;
            $dbObj->post_datetime = $datetime_id_2ch;
            $dbObj->post_txt     = $text_2ch;
            $dbObj->disp_flg      = 1;

            //スレッドデータ INSERT
            $dbObj->insert();

            $i++;
        }

        //オブジェクトのクリア
        $dbObj = NULL;
    }
    //-----------------------------------------
    //-----------------------------------------
    function set_sort_cd(){
        //wk_thread オブジェクトの作成
        $dbObj = new db_wk_thread();
        $result = $dbObj->select_res_data();

        $arr_sort_code = [];
        while ($row = $result->fetch_assoc()) {
            $pos_s = strpos($row['post_txt'], "&gt;&gt;");
            $pos_s = $pos_s + strlen ("&gt;&gt;");

            $wk_txt = substr($row['post_txt'],$pos_s,1);
            $wk_num = 0;
            while (is_numeric($wk_txt)){
                $wk_num = ($wk_num * 10) + intval($wk_txt);

                $pos_s++;
                $wk_txt = substr($row['post_txt'],$pos_s,1);
            }

            $parent_res_id = $row['parent_res_id'];
            if($wk_num != 0){
                $parent_res_id = $wk_num;
            }

            $this->sort_code_init();
            $this->sort_code_add($row['res_id']);
            $this->sort_code_add($parent_res_id);

            if (isset($arr_sort_code[$parent_res_id])) {
                $wk_val = $arr_sort_code[$parent_res_id];
                $this->sort_code_add($wk_val);

                while (isset($arr_sort_code[$wk_val])){
                    $wk_val = $arr_sort_code[$wk_val];
                    $this->sort_code_add($wk_val);
                }
            }

            $arr_sort_code[$row['res_id']] = $parent_res_id;

//            print "----------------------------------<br>";
//            print "::更新情報::<br>";
//            print "thread_id::".$this->thread_id."<br>";
//            print "res_id::".$row['res_id']."<br>";
//            print "sort_code::".$this->sort_code_get()."<br>";

            //親番号の更新
            $dbObj->update_parent_res_id($this->thread_id, $row['res_id'], $parent_res_id);
            $dbObj->update_sort_cd($this->thread_id, $row['res_id'], $this->sort_code_get());
        }
    }

    //-----------------------------------------
    //-----------------------------------------
    function data_organize(){
        //wk_thread オブジェクトの作成
        $dbObj = new db_wk_thread();
        $dbObj->thread_id     = $this->thread_id;
        $dbObj->thread_name   = $this->thread_name;

        //文字数で設定
        $dbObj->hide_setting_txt();

        //DBの値を取得
        $result = $dbObj->select_no_disp();
        while ($row = $result->fetch_assoc()) {
            $dbObj->hide_setting_no_parents($row['res_id']);
        }

        //最後はランダム
        $dbObj->hide_setting_rdm();

        //非表示設定
        //$dbObj->hide_setting();

        $dbObj = NULL;
    }
    

    //-----------------------------------------
    //-----------------------------------------
    function lst_display(){
        global $db_wk_thread;

        //wk_thread オブジェクトの作成
        $db_wk_thread = new db_wk_thread();

        //DBの値を取得
        $result = $db_wk_thread->select_disp();
        while ($row = $result->fetch_assoc()) {
            print "<div  class='t_h t_i'>";
                print $row['thread_num'].":";
                print "<span  style='font-weight: bold; color: green;'>";
                print $row['post_name'].":";
                print "</span>";
                print "<span  style='color: gray;'>";
                print $row['post_datetime'];
                print "</span>";
            print "</div>";

            print "<div  style='font-weight:bold;font-size:18px;line-height:27px;color:#333399;margin-bottom:50px;' class='t_b t_i'>";
                print $row['post_txt'];
            print "</div>";

            print "<BR>";
        }
    }
}

?>
