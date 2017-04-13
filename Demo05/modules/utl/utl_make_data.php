<?php

class cls_make_data {

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
    //--------------------------------
    function old_data_delete(){
        $objDB = new db_m_coupon();
        $objDB->old_delete('2017-04-12');
        $objDB = NULL;
    }
    //--------------------------------
    //--------------------------------
    function xml_ptnA($area, $category_type){

        $wkURL = XML_URL;
        $wkURL = $wkURL."&apikey=".API_KEY;
        $wkURL = $wkURL."&area=".urlencode ($area);
        $wkURL = $wkURL."&category_type=".urlencode($category_type);

        //Debug
        print $wkURL."<br>";

        $rss = simplexml_load_file($wkURL);

$cnt = 0;

        $objDB = new db_m_coupon();
        foreach($rss->item as $item){
            $objDB->init();
$cnt++;
            echo "NO:".$cnt."<br>";
            echo "coupon_id:".$item->coupon_id."<br>";
            echo "coupon_area:".$item->coupon_area."<br>";
            echo "coupon_site:".$item->coupon_site."<br>";

            echo "coupon_url:".$item->coupon_url."<br>";
            echo "coupon_title:".$item->coupon_title."<br>";
//            echo "coupon_summary:".$item->coupon_summary."<br>";
            echo "coupon_addr:".$item->coupon_addr."<br>";
            echo "coupon_access:".$item->coupon_access."<br>";
            echo "coupon_teika:".$item->coupon_teika."<br>";
            echo "coupon_kakaku:".$item->coupon_kakaku."<br>";
            echo "coupon_shop:".$item->coupon_shop."<br>";
            echo "coupon_photo:".$item->coupon_photo."<br>";
            echo "coupon_lat:".$item->coupon_lat."<br>";
            echo "coupon_lng:".$item->coupon_lng."<br>";
            echo "coupon_untilldatetime:".$item->coupon_untilldatetime."<br>";
            echo "coupon_max:".$item->coupon_max."<br>";
            echo "coupon_sold:".$item->coupon_sold."<br>";
            echo "priority:".$item->priority."<br>";
            echo "coupon_site_url:".$item->coupon_site_url."<br>";
            echo "category_type:".$item->category_type."<br>";
            echo "category_name:".$item->category_name."<br>";
            echo "site_code:".$item->site_code."<br>";

            echo "------------------------------------------------------------------<br>";

            $objDB->set_coupon_id($item->coupon_id);
            $objDB->set_coupon_area($item->coupon_area);
            $objDB->set_coupon_site($item->coupon_site);
            $objDB->set_coupon_url($item->coupon_url);
            $objDB->set_coupon_title($item->coupon_title);
            $objDB->set_coupon_summary($item->coupon_summary);
            $objDB->set_coupon_addr($item->coupon_addr);
            $objDB->set_coupon_access($item->coupon_access);
            $objDB->set_coupon_teika($item->coupon_teika);
            $objDB->set_coupon_kakaku($item->coupon_kakaku);
            $objDB->set_coupon_shop($item->coupon_shop);
            $objDB->set_coupon_photo($item->coupon_photo);
            $objDB->set_coupon_lat($item->coupon_lat);
            $objDB->set_coupon_lng($item->coupon_lng);
            $objDB->set_coupon_untilldatetime($item->coupon_untilldatetime);
            $objDB->set_coupon_max($item->coupon_max);
            $objDB->set_coupon_sold($item->coupon_sold);
            $objDB->set_priority($item->priority);
            $objDB->set_coupon_site_url($item->coupon_site_url);
            $objDB->set_category_type($item->category_type);
            $objDB->set_category_name($item->category_name);
            $objDB->set_site_code($item->site_code);

            $objDB->duplicate_insert();

            $time_key = date("YmdHis");
        }
    }

    function main($area, $category_type){
        //
        $this->old_data_delete();
        
        $this->xml_ptnA($area, $category_type);
    }
}

?>

