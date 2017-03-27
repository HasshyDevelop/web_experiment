<?php

class cls_make_data {
    private $ptn;

    function get_threadID($url){
        $result = $url;

        if(mb_substr($result, -1) == "/"){
            $result = substr($result, 0 ,-1);
        }

        $last_pos = strrpos($result, "/") + 1;
        $result = substr($result, $last_pos);

        return $result;
    }

    function xml_ptnA($rss_url){
        $rss = simplexml_load_file($rss_url);
        echo '<ul>';
//        foreach($rss->channel->item as $item){

        $cnt = 1;
        $point = DATA_GET_MAX;
        foreach($rss->item as $item){
            $title = $item->title;
            $date = date("Y年 n月 j日", strtotime($item->pubDate));
            $link = $item->link;

//echo $this->get_threadID($link)."<br>";

            $cnt++;
            $point--;
            if($cnt > DATA_GET_MAX){
                break;
            }

            $description = mb_strimwidth (strip_tags($item->description), 0 , 110, "…Read More", "utf-8");
            ?>
                <li>
                ID:<?php echo $this->get_threadID($link); ?>
                　　
                POINT:<?php echo $point; ?>pt <br>
                <a href="<?php echo $link; ?>" target="_blank">
                <span class="date"><?php echo $date; ?></span>
                <span class="title"><?php echo $title; ?></span>
                <span class="text"><?php echo $description; ?></span>
                </a></li>
            <?php
        }
        echo '</ul>';
    }

    function xml_ptnB($rss_url){
        $rss = simplexml_load_file($rss_url);
        echo '<ul>';
        foreach($rss->channel->item as $item){
            $title = $item->title;
            $date = date("Y年 n月 j日", strtotime($item->pubDate));
            $link = $item->link;

echo $this->get_threadID($link)."<br>";

            $description = mb_strimwidth (strip_tags($item->description), 0 , 110, "…Read More", "utf-8");
            ?>
                <li><a href="<?php echo $link; ?>" target="_blank">
                <span class="date"><?php echo $date; ?></span>
                <span class="title"><?php echo $title; ?></span>
                <span class="text"><?php echo $description; ?></span>
                </a></li>
            <?php
        }
        echo '</ul>';
    }


    function rktn_html_analysis($url){
        $html = mb_convert_encoding(file_get_contents($url), 'UTF-8', 'EUC-JP');

        $html = preg_replace('/<\s*meta\s+charset\s*=\s*["\'](.+)["\']\s*\/?\s*>/i', '<meta charset="${1}"><meta http-equiv="Content-Type" content="text/html; charset=${1}">', $html);


preg_match_all("/\<.*? class=[\"|\'].*?kWdWrd.*?[\"|\']>(.*?)<\/.*?>/", $html, $result,PREG_PATTERN_ORDER);

$arrItem = $result[1];

for ($i = 0 ; $i < count($arrItem); $i++) {
    echo ($i+1)."位：".$arrItem[$i];
    echo "<BR>";
}

/*
$dom = new DOMDocument();
@$dom->loadHTML($html);
$xml = simplexml_import_dom($dom);//解析したXML文字列をオブジェクトに変換します。

$json = json_encode($xml);
$scraped_data = json_decode($json,true);

var_dump($scraped_data);

print "<textarea>";

print $html;

print "</textarea>";
*/


    }

    function main(){
        $dbObj  = new db_m_feed_account();
        $result = $dbObj->select_all();

        while ($row = $result->fetch_assoc()) {

            $id   = $row['id'];
            $Name = mb_convert_encoding($row['name'], "UTF-8", "auto");
            $url  = $row['url'];
            $ptn  = $row['make_ptn'];

            print $id."<br>";
            print $Name."<br>";
            print $url."<br>";
            print $ptn."<br>";

            //
            switch ($ptn) {
                case 1:
                    $this->xml_ptnA($row['url']);
                    break;
                case 2:
                    $this->xml_ptnB($row['url']);
                    break;
                defaul:
                    echo "パターンエラー<br>";
                    break;
            }


        }
    }
}

?>

