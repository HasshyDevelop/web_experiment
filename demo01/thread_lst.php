<?php
    require_once 'modules/require.php';

    //ヘッダー出力
    hrml_head();

    //TOP メニュー
    html_top_menu();

    //コンテンツ
    contents_start();
    html_left_contents();

    print "<div id=\"main\">";

    $dat_url    =  isset($_GET['dat_url']) ? htmlspecialchars($_GET['dat_url']) : null;
    $board_id   =  isset($_GET['board_id']) ? htmlspecialchars($_GET['board_id']) : null;
    $thread_id  =  isset($_GET['thread_id']) ? htmlspecialchars($_GET['thread_id']) : null;

    $dbObj = new db_d_thread();
    $result = $dbObj->select_with_key($board_id, $thread_id);
    while ($row = $result->fetch_assoc()) {
        $thread_date = $row['thread_date'];
        $thread_name = $row['thread_name'];
    }

    print "<h2>".$thread_date."</h2><h3>".$thread_name."</h3>";
    print "<h3>".$dat_url."</h3>";

    //ワークテーブルの作成
    $utlObj = new utl_thread();
    $utlObj->set_thread_id($thread_id);
    $utlObj->set_thread_name($thread_name);
    $utlObj->set_dat_url($dat_url);
//    $utlObj->make_data();
//    $utlObj->set_sort_cd();
//    $utlObj->data_organize();

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

    //コンテンツ
    html_right_contents();
    contents_end();

    //フッター出力
    hrml_foot();

    //DB クローズ
    $G_MY_SQLI->close();
    //get_parents_id_from_sort_cd

    function get_div_width($val_F, $val_T){
        $width = 100;

        $arrFrom = explode('-', $val_F);
        $arrTo   = explode('-', $val_T);
        
        for($i=0; $i<count($arrFrom); $i++){
            if($arrFrom[$i] <> $arrTo[$i]){
                $width -= 4;
            }
        }
        
        return $width."%";
    }
?>
