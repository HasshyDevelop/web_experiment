<?php
    require_once 'modules/cls_html.php';




class cls_htmL_index extends cls_html
{
    //OVER RIDE
    public function page_contents()
    {
        echo "オーバーライド　OK";
    }
}


    $objHtml = new cls_htmL_index('./');
    $objHtml->main();


?>


