<?php
    
    //-----------------------------------------
    //  HTML ヘッダの出力
    //-----------------------------------------
    function hrml_head(){
        global $G_HTML_STYLE_ARR, $G_HTML_JS_ARR;
        
        require_once PATH_TPL.'head.tpl';
    }

    //-----------------------------------------
    //  HTML フッターの出力
    //-----------------------------------------
    function hrml_foot(){
        global $G_HTML_STYLE_ARR, $G_HTML_JS_ARR;
        
        require_once PATH_TPL.'foot.tpl';
    }

    //-----------------------------------------
    //  HTML コンテンツ開始タグの出力
    //-----------------------------------------
    function contents_start() {
        print "<div id=\"contents\">";
    }

    //-----------------------------------------
    //  HTML コンテンツ終了タグの出力
    //-----------------------------------------
    function contents_end() {
        print "</div>";
    }

    //-----------------------------------------
    //  TOP メニュー 
    //-----------------------------------------
    function html_top_menu(){
        global $G_HTML_STYLE_ARR, $G_HTML_JS_ARR;
        
        print "   <div id=\"menu\">";
        print "      <ul>";
        print "      <li><a href=\"index.php\">HOME</a></li>";
        print "      <li><a href=\"index.html\">MENU2</a></li>";
        print "      <li><a href=\"index.html\">MENU3</a></li>";
        print "      <li><a href=\"index.html\">MENU4</a></li>";
        print "      <li><a href=\"index.html\">MENU5</a></li>";
        print "      <li><a href=\"index.html\">MENU6</a></li>";
        print "      </ul>";
        print "   </div>";

    }


    //-----------------------------------------
    //  コンテンツ　左
    //-----------------------------------------
    function html_left_contents(){
        global $G_HTML_STYLE_ARR, $G_HTML_JS_ARR;
        
        require_once PATH_TPL.'contents.tpl';
    }

    //-----------------------------------------
    //  コンテンツ　右
    //-----------------------------------------
    function html_right_contents(){
        global $G_HTML_STYLE_ARR, $G_HTML_JS_ARR;
        
//        print "      <div id=\"subR\">";
//        print "         <div class=\"section\">";
//        print "            <h2>PR</h2>";
//        print "            <div class=\"pr\"><img src=\"img/banner_pr_side.gif\" alt=\"\" /></div>";
//        print "         </div>";
//        print "      </div>";

    }

?>
