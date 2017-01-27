<?php
    require_once 'modules/require.php';

    //ヘッダー出力
    hrml_head();

    //TOP メニュー
    html_top_menu();

    //コンテンツ
    contents_start();

    $upd_mode =  isset($_GET['upd_mode']) ? htmlspecialchars($_GET['upd_mode']) : null;    html_left_contents();

    print "<div id=\"main\">";

    print "<h2>m_board 更新</h2>";

    print "<b>最新データを取得します。<br>注：現在のソート順はクリアされます。</b>";
    print "<form method='GET' action=''>";
    print "<br>";
    print "<input type='hidden' name='upd_mode' value='1' >";
    print "<input type='submit' value='更新' style='width:200px;'>";
    print "<br><br>";
    print "</form>";

    print "<h3></h3>";


    if($upd_mode == 1){
        print "<h3>ログ</h3>";
        print "<TEXTAREA rows=\"40\" style=\"border: 0px; width:100%; \" readonly>";
        $m_board = new db_m_board();

        //ソートIDを退避
        //$sort_result    = $m_board->select_sortno(ODR_SORT);


        $m_board->re_create_with_sort_no();

//        $m_thread->re_create();

        print "完了：：</TEXTAREA>";
    }


    print "</div>";

    //コンテンツ
    html_right_contents();
    contents_end();

    //フッター出力
    hrml_foot();

    //DB クローズ
    $G_MY_SQLI->close();

?>
