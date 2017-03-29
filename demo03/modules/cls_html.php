<?php
class cls_html
{
    private $inc_dir;

    function __construct($val) {
        $this->inc_dir = $val;
    }

    public function main()
    {
        $this->html_head();
        print "<body>"."\n";
        print "<div id=\"top\">"."\n";

        $this->page_header();

        print "<div id=\"contents\">"."\n";
        $this->page_contents();
        print "</div><!-- /#contents-->"."\n";

        $this->page_footer();

        print "</div><!-- /#top-->"."\n";
        print "</body>"."\n";
        print "</html>"."\n";

    }

    function html_head()
    {
        $css_path = $this->inc_dir."css/common.css";
        require_once $this->inc_dir.'modules/tpl_html_head.php';
    }

    public function page_header()
    {
        $idx_path  = $this->inc_dir."index.php";
        $rank_path = $this->inc_dir."makeblg/";
        $thread_path = $this->inc_dir."makeblg/make_thread.php";
        $board_path = $this->inc_dir."makeblg/make_board.php";


        echo '<div id="header">'."\n";
        echo '<h1><a href="index.html">DEMO 03</a></h1>'."\n";
        echo '<p>'."\n";
        echo 'ここにサブタイトルやサイトの説明文をお書きください。'."\n";
        echo '</p>'."\n";
        echo '<div id="navi">'."\n";
        echo '<ul>'."\n";
        echo '<li class="sitemap"><a href="">SITEMAP</a></li>'."\n";
        echo '<li class="contact"><a href="">CONTACT</a></li>'."\n";
        echo '<li class="feed"><a href="">RSS</a></li>'."\n";
        echo '</ul>'."\n";
        echo '</div><!-- /#navi-->'."\n";
        echo '</div><!-- /#header-->'."\n";
        echo '<div id="menu">'."\n";
        echo '<ul>'."\n";
        echo '<li><a href="'.$idx_path.'" class="on">HOME</a></li>'."\n";
        echo '<li><a href="'.$rank_path.'">RNK</a></li>'."\n";
        echo '<li><a href="'.$thread_path.'">THREAD</a></li>'."\n";
        echo '<li><a href="#">DIARY</a></li>'."\n";
        echo '<li><a href="#">GALLERY</a></li>'."\n";
        echo '<li><a href="#">BOOKMARK</a></li>'."\n";
        echo '<li><a href="'.$board_path.'">BOARD</a></li>'."\n";
        echo '</ul>'."\n";
        echo '</div><!-- /#menu-->'."\n";
    }

    public function page_contents()
    {
        require_once $this->inc_di.'tpl_html_contents_dample.php';
    }


    public function page_footer()
    {
        echo '<div id="pageTop">'."\n";
        echo '<a href="#top">ページのトップへ戻る</a>'."\n";
        echo '</div><!-- /#pageTop-->'."\n";
        echo '<div id="footer">'."\n";
        echo '    <div class="copyright">Copyright &copy; 2011 YOUR SITE NAME All Rights Reserved.</div>'."\n";
        echo '</div><!-- /#footer-->'."\n";
    }
}
?>
