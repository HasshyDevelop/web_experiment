<?php

class cls_make_thread_data {
    private $thread_id;
    private $thread_name;
    private $base_board_url;
    private $base_dat_url;

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
    function make_data(){
        global $G_TODAY;

        //file_get_contents関数でデータを取得
        //DATファイル取得
        if($html=@file_get_contents($this->dat_url)){
            //取得成功
            //UTFに変換
            $html=mb_convert_encoding($html,'utf8','sjis-win');
            //余計な文字を削除
            //余計な</b><b>が入っている場合があるので、一つずつ削除
            $html=str_replace('<b>','',$html);
            $html=str_replace('</b>','',$html);
            //アンカーのリンクは邪魔なので外す。@はデリミタ
            $html=preg_replace('@<a(?:>| [^>]*?>)(.*?)</a>@s','$1',$html);

            //各要素をばらす
            //行ごとになっている各レスを独立
            preg_match_all('/(.*?)\n/u',$html,$lines);

            //wk_thread オブジェクトの作成
            $dbObj = new db_wk_thread();
            //スレッドデータクリア
            $dbObj->truncate();

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

            return true;
        }else{
            //エラー処理
            if(count($http_response_header) > 0){
                //「$http_response_header[0]」にはステータスコードがセットされているのでそれを取得
                $status_code = explode(' ', $http_response_header[0]);  //「$status_code[1]」にステータスコードの数字のみが入る
         
                echo "<font color=red>";
                //エラーの判別
                switch($status_code[1]){
                    //404エラーの場合
                    case 404:
                        echo "指定したページが見つかりませんでした";
                        break;
         
                    //500エラーの場合
                    case 500:
                        echo "指定したページがあるサーバーにエラーがあります";
                        break;
         
                    //その他のエラーの場合
                    default:
                        echo "何らかのエラーによって指定したページのデータを取得できませんでした";
                }
                echo "</font>";
                echo "<br>";
            }else{
                //タイムアウトの場合 or 存在しないドメインだった場合
                echo "タイムエラー or URLが間違っています";
            }

            return false;
        }
    }

    //-----------------------------------------
    //-----------------------------------------
    function get_subject($in_thread_id, $board_url){
        $thread_txt = $board_url.THREAD_TXT_NAME;
        //txtファイルを開ける
        $thread_list = @fopen($thread_txt,'r');
        
        if($thread_list){
            //ファイルの最後まで読みに行く
            while(!feof($thread_list)){
                //1行ずつ取得
                $line = fgets($thread_list);
                //UTF-8に変換
                $line = mb_convert_encoding($line,'utf8','sjis-win');
                //スレナンバーを取得
                //.dat<>が何文字目か、0から数える
                $thread_id_num = mb_strpos($line,'.dat<>');
                //0番目からスレナンバーの桁分抽出
                $thread_id = mb_substr($line,0,$thread_id_num);
                if($in_thread_id == $thread_id){
                    //IDが一致したら取得
                    //thread_name　以外は不要だが一応取得しておく
                    //------------------------------------------------------
                    //レス数を取得
                    //------------------
                    //「)」が最後に現れる文字が何番目か
                    $last = mb_strrpos($line,')')-1;
                    //「 (」が最後に現れる文字が何番目か
                    $first = mb_strrpos($line,' (')+1;
                    //レス数の桁
                    $n = $last-$first;
                    //スレナンバー抽出
                    $num = mb_substr($line,$first+1,$n);
                    //スレ名を取得
                    //スレ名の文字数、7は「.dat<>」の文字数と0番目の1文字
                    $name = $first-7-$thread_id_num;
                    //6は「.dat<>」の文字数
                    $thread_name = mb_substr($line,$thread_id_num+6,$name);
                    $thread_date = date("Y-m-d H:i:s",$thread_id);
//                    $dat_url = $this->board_url."dat/".$thread_id.".dat";

                    //
                    $this->thread_name = $thread_name;
                    break;
                }
            }
        }
        //ファイルを閉める
        @fclose($thread_list);
    }

    function main(){
//Debug
$board_id     = "newsplus";

        $dbObj  = new db_d_ranking();
        $loopFlg = true;
        $loopCnt = 1;
        while ($loopFlg) {
            $result = $dbObj->select_random($board_id);

            while ($row = $result->fetch_assoc()) {
                $board_url = str_replace('test/read.cgi/',NULL,$row['read_url']);
                $board_url = str_replace($row['thread_id'],NULL,$board_url);

                $this->get_subject($row['thread_id'],$board_url);

                $this->thread_id = $row['thread_id'];
                $this->dat_url = $row['dat_url'];

                //データ作成
                if($this->make_data()){
                    $loopFlg = false;
                }
                //$this->set_sort_cd();
                //$this->data_organize();

                //Debug
                print $row['board_id']."：";
                print $row['thread_id']."<br>";
                print $row['thread_id']."<br>";
                print "スレタイ：".$this->thread_name."<br>";

                //print $row['max_rank']."<br>";
                //print $row['point']."<br>";
                //print $row['update_date']."<br>";
                //print "BASE ".$this->base_board_url."<br>";
                //print "DAT  ".$this->base_dat_url."<br>";

                print "引用元 ".$this->thread_name."<br>";
                print "　　　 ".str_replace('[THREAD_ID]',$row['thread_id'],$this->base_board_url)."<br>";
    //            print $this->dat_url;
                print "***********************************************<br>";

                //
                $this->wk_thread_disp($row['thread_id']);
                break;
            }
            
            $loopCnt++;
            if($loopFlg == true && $loopCnt >= 5){
                $loopFlg = false;
            }
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
            //if($utlObj->get_parents_id_from_sort_cd($wk_sort_cd) <> $utlObj->get_parents_id_from_sort_cd($row['sort_cd'])){
            //    $wk_sort_cd = $row['sort_cd'];
            //    $css_ptn = 0;
            //}else{
            //    $css_ptn = 1;
            //}

            //$width = get_div_width($wk_sort_cd, $row['sort_cd']);
$width = 150;
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

