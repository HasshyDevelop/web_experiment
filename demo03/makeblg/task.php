<?php
    require_once './modules/require.php';
    require_once '../modules/cls_html.php';


class cls_htmL_task extends cls_html
{
    //OVER RIDE
    public function page_contents()
    {
//        echo "オーバーライド　OK";
print '<form action"">';
print '<input type="submit" value="　　　　　PUSH　　　　　">';
print '</ form>';
print '<BR><BR>';

        $objUtil = new cls_task();
        $objUtil->exec_task();
    }
}
    $objHtml = new cls_htmL_task('./../');
    $objHtml->main();
?>


