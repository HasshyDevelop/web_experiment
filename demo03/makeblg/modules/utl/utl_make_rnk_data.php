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

    //--------------------------------
    // パターン　A
    //--------------------------------
    function xml_ptnA($dbFeedObj){
        $rss = simplexml_load_file($dbFeedObj->get_url());

//        foreach($rss->channel->item as $item){

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

                $objDB->set_board_id($dbFeedObj->get_board_id());
                $objDB->set_thread_id($this->get_threadID($link));
                $objDB->set_max_rank($cnt);
                $objDB->set_point($point);

                $objDB->ins_duplicate_upd();

                $cnt++;
                $point--;
                if($cnt > DATA_GET_MAX){
                    break;
                }

                //Debug
                print "ID:".$this->get_threadID($link)."　　POINT:".$point."pt <br>";
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

                $objDB->set_board_id($dbFeedObj->get_board_id());
                $objDB->set_thread_id($this->get_threadID($link));
                $objDB->set_max_rank($cnt);
                $objDB->set_point($point);

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

