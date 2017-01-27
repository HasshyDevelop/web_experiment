<?php
    //-----------------------------------------
    //-----------------------------------------
    function fcWriteThread(){
        global $G_TODAY;

        //wk_thread オブジェクトの作成
        $db_wk_thread = new db_wk_thread();

        //スレッドデータクリア
        $db_wk_thread->truncate();

//        $dat_url='http://ikura.2ch.sc/anime2/dat/1347023380.dat';//2ch該当スレDATファイルのURL
//        $dat_url='http://viper.2ch.sc/test/read.cgi/news4vip/1483773703/';
//        $dat_url='http://hayabusa.open2ch.net/test/read.cgi/news4vip/1484120433/';
        $dat_url='http://ikura.2ch.sc/anime2/dat/1317735318.dat';

        //DATファイル取得
        $html=file_get_contents($dat_url);
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
            $db_wk_thread->init();

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
            $db_wk_thread->thread_num    = $i;
            $db_wk_thread->res_number    = 0;
            $db_wk_thread->post_name     = $name_2ch;
            $db_wk_thread->post_mail     = $mail_2ch;
            $db_wk_thread->post_datetime = $datetime_id_2ch;
            $db_wk_thread->post_txt     = $text_2ch;
            $db_wk_thread->disp_flg      = 1;

            //スレッドデータ INSERT
            $db_wk_thread->insert();

            $i++;
        }

        fcThreadListDisp();

        //オブジェクトのクリア
        $db_wk_thread = NULL;

    }

    //-----------------------------------------
    //-----------------------------------------
    function fcThreadListDisp(){
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

?>
