<?php

class cls_make_thread_data {
    private $thread_id;
    private $thread_name;
    private $dat_url;

    private $wk_sort_code = array();

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

    function main(){
//Debug
$board_id     = "newsplus";
$base_dat_url = "http://ai.2ch.sc/newsplus/dat/[THREAD_ID].dat";

        $dbObj  = new db_d_ranking();
        $result = $dbObj->select_sort_rnk($board_id,RNK_ORDER_DEF);

        while ($row = $result->fetch_assoc()) {
            //Debug
            print $row['board_id']."<br>";
            print $row['thread_id']."<br>";
            print $row['max_rank']."<br>";
            print $row['point']."<br>";
            print $row['update_date']."<br>";
            print "***********************************************<br>";

            $this->thread_id = $row['thread_id'];
            //private $thread_name;
            $this->dat_url = str_replace('[THREAD_ID]',$row['thread_id'],$base_dat_url);

print $this->dat_url;

//            $this->make_data();

            $this->wk_thread_disp($row['thread_id']);
            break;

/*
            //
            switch ($dbFeedObj->get_make_ptn()) {
                case 1:
                    $this->xml_ptnA($dbFeedObj);
                    break;
                case 2:
                    $this->xml_ptnB($dbFeedObj);
                    break;
                defaul:
                    echo "パターンエラー<br>";
                    break;
            }
*/

        }
    }

//*** 以下 DEBUG用 ***********************************
    //結果の表示
    function wk_thread_disp($thread_id){
        //wk_thread オブジェクトの作成
        $dbObj = new db_wk_thread();
        $dbObj->thread_id = $thread_id;

        //DBの値を取得
        $result = $dbObj->select_disp();

    //    $result = $dbObj->debug_select_disp();

        $wk_sort_cd = "";
        $css_ptn = 1;
        while ($row = $result->fetch_assoc()) {
            //スタイルパターンを設定
            if($utlObj->get_parents_id_from_sort_cd($wk_sort_cd) <> $utlObj->get_parents_id_from_sort_cd($row['sort_cd'])){
                $wk_sort_cd = $row['sort_cd'];
                $css_ptn = 0;
            }else{
                $css_ptn = 1;
            }

            $width = get_div_width($wk_sort_cd, $row['sort_cd']);
            $div_head = "<div  style='width:".$width.";font-size:10px; color:#666666; margin: 0px 0px 0px 0px;padding: 0px 0px 0px 10px;";
            //ID エリア
            switch($css_ptn){ 
            case 1:
                $div_head = $div_head." margin-left: auto;'>";
                break;
            default:
                $div_head = $div_head."'>";
    //            print "<div  style='width:".$width.";font-size:10px; color:#666666;'>";
                break;
            }

            print $div_head;
            print $row['res_id'].":";
            print "<span  style='font-weight: bold; color: rgb(1, 131, 51);'>";
            print $row['post_name'].":";
            print "</span>";
            print "<span  style='color: gray;'>";
            print $row['post_datetime'];
            print "</span>";
            print "</div>";

            //メッセージ エリア
            $div_body = "<div  style='font-weight:bold;color:#333399;width:".$width."; font-size:16px;margin: 0px 0px 30px 00px;padding: 0px 0px 0px 10px;";
            switch($css_ptn){
            case 1:
                $div_body = $div_body."margin-left: auto; background: #eeeeee;'>";
                break;
            default:
                $div_body = $div_body."'>";
                break;
            }
            print $div_body;
            print $row['post_txt'];
            print "</div>";
            //
            //print "<BR>";
        }
        print "</div>";
    }


}

?>

