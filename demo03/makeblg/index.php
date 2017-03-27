<?php
    require_once './modules/require.php';
    require_once '../modules/cls_html.php';


class cls_htmL_index extends cls_html
{
    //OVER RIDE
    public function page_contents()
    {
//        echo "オーバーライド　OK";
        $objUtil = new cls_make_data();
        $objUtil->main();
    }
}
    $objHtml = new cls_htmL_index('./../');
    $objHtml->main();
?>


