<?php
    //-----------------------------------------
    //-----------------------------------------
    function fcWriteThread(){
        global $G_TODAY;

        //スレッドデータクリア
        d_thread_clear();

//        $dat_url='http://ikura.2ch.sc/anime2/dat/1347023380.dat';//2ch該当スレDATファイルのURL
        $dat_url='http://viper.2ch.sc/test/read.cgi/news4vip/1483773703/';
//        $dat_url='http://hayabusa.open2ch.net/test/read.cgi/news4vip/1484120433/';
//        $dat_url='http://hayabusa.open2ch.net/news4vip/1484120433.dat';


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

//        print '<dl>';

        $i=1;
        foreach($lines[0] as $line){
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
            $text_arr = MY_STR_SPLIT($text_2ch, 200);
            switch (count($text_arr)){
            case 1:
                array_push($text_arr, "","","","");
                break;
            case 2:
                array_push($text_arr, "","","");
                break;
            case 3:
                array_push($text_arr, "","");
                break;
            case 4:
                array_push($text_arr, "");
                break;
            default:
                break;
            }

            $d_thread['thread_num'] = $i;
            $d_thread['res_number'] = 0;
            $d_thread['post_name'] = $name_2ch;
            $d_thread['post_mail'] = $mail_2ch;
            $d_thread['post_datetime'] = $datetime_id_2ch;
            $d_thread['post_txt1'] = $text_arr[0];
            $d_thread['post_txt2'] = $text_arr[1];
            $d_thread['post_txt3'] = $text_arr[2];
            $d_thread['post_txt4'] = $text_arr[3];
            $d_thread['post_txt5'] = $text_arr[4];
            $d_thread['disp_flg'] = 1;

            //スレッドデータ INSERT
            d_thread_ins($d_thread);

            $i++;
        }

        //DBの値を取得
        $result = d_thread_select_disp();
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

    //-----------------------------------------
    //-----------------------------------------
    function fcGetThreadList(){
        //板一覧を読み込む
        $html=file_get_contents('http://menu.2ch.sc/bbsmenu.html');
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

        //各要素を取得
        foreach($res as $link){
            $name=$link[1];//板名
            $url=$link[0];//URL

            //板IDだけを独立して取得
            preg_match('{2ch.sc/(.*)/$}',$url,$ch);
            $id=$ch[1];

            print '板名：'.$name.'<br />';
            print '板URL：'.$url.'<br />';
            print '板ID：'.$id.'<br />';
        }

        //採番するコードをここに入れますがPRIMARYは使いません。取得する度に採番し直しています。
    }
?>
