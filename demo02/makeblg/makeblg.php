<?php
    require_once './modules/require.php';
    require_once '../modules/cls_html.php';


class cls_htmL_index extends cls_html
{
    //OVER RIDE
    public function page_contents()
    {
//        echo "オーバーライド　OK";
//        $objUtil = new cls_make_data();
//        $objUtil->main();

//*****************************
// google news
//*****************************
//$rss_url = "http://news.google.com/news?hl=ja&ned=us&ie=UTF-8&oe=UTF-8&output=rss&topic=e";
//$gxml = simplexml_load_file($rss_url);

//foreach ($gxml->channel->item as $item) {
//    echo $item->title;
//    echo "<br>";
//    echo $item->description;
//}
//******************************************************************************************************************************************************************************


 $rss_url = "http://news.livedoor.com/topics/rss/top.xml";
        $rss = simplexml_load_file($rss_url);
        echo '<ul>';
        foreach($rss->channel->item as $item){
            $title = $item->title;
            $date = date("Y年 n月 j日", strtotime($item->pubDate));
            $link = $item->link;
            $description = mb_strimwidth (strip_tags($item->description), 0 , 110, "…Read More", "utf-8");

            if(strpos($link,'news.livedoor.com') !== false){
                ?>
                    <li><a href="<?php echo $link; ?>" target="_blank">

                    <span class="title"><?php echo $title; ?></span>
<!--
                    <span class="text"><?php echo $description; ?></span>
-->
                    </a></li>
                <?php

                $url  = $link;
                $html = mb_convert_encoding(file_get_contents($url), 'UTF-8', 'EUC-JP');

//$html = mb_convert_encoding(file_get_contents($url), 'UTF-8', 'EUC-JP');
$html = $link;
$doc = new DOMDocument();
$doc->loadHTML($html);
$xml = $doc->saveXML();
$xmlObj = simplexml_load_string($xml);
//var_dump($xmlObj[0);

                $html = preg_replace('/<\s*meta\s+charset\s*=\s*["\'](.+)["\']\s*\/?\s*>/i', '<meta charset="${1}"><meta http-equiv="Content-Type" content="text/html; charset=${1}">', $html);

                preg_match_all("/\<.*? itemprop=[\"|\'].*?articleBody.*?[\"|\']>(.*?)<\/.*?>/", $html, $result,PREG_PATTERN_ORDER);

                var_dump($result);
                break;
            }
        }

/*







$arrItem = $result[1];

for ($i = 0 ; $i < count($arrItem); $i++) {
    echo ($i+1)."位：".$arrItem[$i];
    echo "<BR>";
}
*/



        echo '</ul>';


    }
}
    $objHtml = new cls_htmL_index('./../');
    $objHtml->main();
?>


