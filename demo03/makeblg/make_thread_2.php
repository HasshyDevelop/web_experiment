<?php
    require_once './modules/require.php';
    require_once '../modules/cls_html.php';


class cls_htmL_index extends cls_html
{
    //OVER RIDE
    public function page_contents()
    {
//        echo "オーバーライド　OK";
        $objUtil = new cls_make_thread_data();
        $objUtil->set_sort_cd();
    }
}
    $objHtml = new cls_htmL_index('./../');
    $objHtml->main();
?>


