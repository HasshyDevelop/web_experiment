<?php

class cls_make_rnk_data {

    function get_threadID($url){
        $result = $url;

        if(mb_substr($result, -1) == "/"){
            $result = substr($result, 0 ,-1);
        }

        $last_pos = strrpos($result, "/") + 1;
        $result = substr($result, $last_pos);

        return $result;
    }

    //-----------------------------------------
    //-----------------------------------------
    function get_thread_subject($in_thread_id, $board_url){
        $result = "";
        $thread_txt = $board_url."/".THREAD_TXT_NAME;

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
                    $dat_url = $board_url."dat/".$thread_id.".dat";
                    
                    $result = $thread_name;
                    break;
                }
            }
        }
        //ファイルを閉める
        @fclose($thread_list);

        return $result;
    }

    //-----------------------------------------
    //-----------------------------------------
    function get_board_info($board_id,$thread_id){
        $board_info = array("board_url" => "",
                            "read_url"  => "",
                            "dat_url"   => "");

        $dbObj  = new db_m_board();
        $result = $dbObj->select_with_key($board_id);

        while ($row = $result->fetch_assoc()) {
            $board_info["board_url"]  = $row['board_url'];;
            $board_info["read_url"]   = str_replace(CNV_STR_THREAD_ID,$thread_id,$row['read_url']);;
            $board_info["dat_url"]    = str_replace(CNV_STR_THREAD_ID,$thread_id,$row['dat_url']);;
        }

        return $board_info;
    }

    //--------------------------------
    // パターン　A
    //--------------------------------
    function xml_ptnA($dbFeedObj){
        $rss = simplexml_load_file($dbFeedObj->get_url());

        $cnt = 1;
        $point = DATA_GET_MAX;
        $objDB = new db_d_ranking();
        //古いデータは削除
        $objDB->old_data_delete();

        $new_feed_data = date('Y-m-d H:i:s', strtotime($rss->channel->children("http://purl.org/dc/elements/1.1/")->date));
        //Debug
        print "日付：".$dbFeedObj->get_feed_date()."：".$new_feed_data."<br>";

        if($dbFeedObj->get_feed_date() != $new_feed_data){

            foreach($rss->item as $item){
                $objDB->init();

                $title = $item->title;
                $link = $item->link;

                $board_id       = $dbFeedObj->get_board_id();
                $thread_id      = $this->get_threadID($link);
                $borad_info     = $this->get_board_info($board_id,$thread_id);
//                $thread_name    = $this->get_thread_subject($thread_id, $borad_info["board_url"]);
                $time_key = date("YmdHis");

                $objDB->set_board_id($board_id);
                $objDB->set_thread_id($thread_id);
                $objDB->set_time_key($time_key);
//                $objDB->set_thread_name($thread_name);
                $objDB->set_max_rank($cnt);
                $objDB->set_point($point);
                $objDB->set_read_url($borad_info["read_url"]);
                $objDB->set_dat_url($borad_info["dat_url"]);

//                $objDB->ins_duplicate_upd();
                $objDB->insert();

                $cnt++;
                $point--;
                if($cnt > DATA_GET_MAX){
                    break;
                }

                //Debug
                print "ID:".$thread_id."　　POINT:".$point."pt <br>";
                print "<a href=\"".$link."\" target='_blank'>";
                print "<span class=\"title\">".$title."</span>";
                print "</a><br>";
            }
            //取得日のUpdate
            $dbObj  = new db_m_feed_account();
            $dbObj->set_id($dbFeedObj->get_id());
            $dbObj->set_feed_date($new_feed_data);
            $dbObj->upd_feed_date();
        }

    }

    //--------------------------------
    // パターン　B
    //--------------------------------
    function xml_ptnB($dbFeedObj){
        $rss = simplexml_load_file($dbFeedObj->get_url());

        $cnt = 1;
        $point = DATA_GET_MAX;
        $objDB = new db_d_ranking();
        //古いデータは削除
        $objDB->old_data_delete();

        $new_feed_data = date('Y-m-d H:i:s', strtotime($rss->channel->children("http://purl.org/dc/elements/1.1/")->date));
        //Debug
        print "日付：".$dbFeedObj->get_feed_date()."：".$new_feed_data."<br>";

        if($dbFeedObj->get_feed_date() != $new_feed_data){
            foreach($rss->channel->item as $item){
                $title = $item->title;
                $date = date("Y年 n月 j日", strtotime($item->pubDate));
                $link = $item->link;

                $objDB->init();

                $title = $item->title;
                $link = $item->link;

                $board_id       = $dbFeedObj->get_board_id();
                $thread_id      = $this->get_threadID($link);
                $borad_info     = $this->get_board_info($board_id,$thread_id);
                //$thread_name    = $this->get_thread_subject($thread_id, $borad_info["board_url"]);
                $time_key = date("YmdHis");

                $objDB->set_board_id($board_id);
                $objDB->set_thread_id($thread_id);
                $objDB->set_time_key($time_key);
                //$objDB->set_thread_name($thread_name);
                $objDB->set_max_rank($cnt);
                $objDB->set_point($point);
                $objDB->set_read_url($borad_info["read_url"]);
                $objDB->set_dat_url($borad_info["dat_url"]);

                $objDB->ins_duplicate_upd();

                $cnt++;
                $point--;
                if($cnt > DATA_GET_MAX){
                    break;
                }

                //Debug
                print "<a href=\"".$link."\" target='_blank'>";
                print "<span class=\"title\">".$title."</span>";
                print "</a><br>";
            }

            //取得日のUpdate
            $dbObj  = new db_m_feed_account();
            $dbObj->set_id($dbFeedObj->get_id());
            $dbObj->set_feed_date($new_feed_data);
            $dbObj->upd_feed_date();

        }
    }

    function main(){
        $dbFeedObj  = new db_m_feed_account();
        $result = $dbFeedObj->select_all();

        while ($row = $result->fetch_assoc()) {
            $dbFeedObj->set_id($row['id']);
            $dbFeedObj->set_name(mb_convert_encoding($row['name'], "UTF-8", "auto"));
            $dbFeedObj->set_url($row['url']);
            $dbFeedObj->set_board_id($row['board_id']);
            $dbFeedObj->set_make_ptn($row['make_ptn']);
            $dbFeedObj->set_feed_date($row['feed_date']);

            //Debug
            print $dbFeedObj->get_id()."<br>";
            print $dbFeedObj->get_name()."<br>";
            print $dbFeedObj->get_url()."<br>";
            print $dbFeedObj->get_board_id()."<br>";
            print $dbFeedObj->get_make_ptn()."<br>";
            print $dbFeedObj->get_feed_date()."<br>";
            print "***********************************************<br>";

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


        }
    }
}

?>

