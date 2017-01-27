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
    print "<H1>TEST</H1>";
    print "</div>";

    //コンテンツ
    html_right_contents();
    contents_end();

    //フッター出力
    hrml_foot();

    //DB クローズ
    $G_MY_SQLI->close();

?>
