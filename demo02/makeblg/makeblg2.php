<?php
    require_once './modules/require.php';
    require_once '../modules/cls_html.php';

    $bold_word = "";

function blg_body_cnv($word){
    global $bold_word;

echo $bold_word."    BBBBB<br>";

//var_dump($xml);

    $blg_body = str_replace ($bold_word,'<b>'.$bold_word.'</b>',$word);
    $word = str_replace ('。','。<br>',$word);
    return $word;
}

class cls_htmL_index extends cls_html
{
    //OVER RIDE
    public function page_contents()
    {
        global $bold_word;

     $blg_body = "昨年４月１日に芸能界引退を発表した元女優の吉田里琴が、吉川愛（１７）として復帰したことが６日までに分かった。
　今月１日、大手事務所・研音に所属した。ＹｏｕＴｕｂｅの研音オフィシャルチャンネルで「皆さん、こんにちは。４月１日より研音に所属になりました吉川愛です。出身は東京都です。趣味は音楽鑑賞と映画鑑賞です。とにかくいろんなことにチャレンジしていきたいと思っています。応援よろしくお願いします」と笑顔で手を振り、あいさつしている。
　ＮＨＫ連続テレビ小説「あまちゃん」やフジテレビ「リーガル・ハイ」など出演し、天才子役として知られた。";

        $new_blg_body = $blg_body;

        echo "【元記事】<br>";
        echo $blg_body;
        echo "<br><br><br>";

//------------------------------------------------
    $appid = 'dj0zaiZpPTNJUnQ2YkpZRjlHdyZzPWNvbnN1bWVyc2VjcmV0Jng9OTM-'; // <-- ここにあなたのアプリケーションIDを設定してください。
    $url = "http://jlp.yahooapis.jp/MAService/V1/parse?appid=".$appid."&results=ma";
    $url = "http://jlp.yahooapis.jp/KeyphraseService/V1/extract?appid=".$appid;
    $url .= "&sentence=".urlencode($blg_body);
    $xml  = simplexml_load_file($url);

    $cnt = 0;
    $arrWord = array();
    foreach((array)$xml->Result as $Result){
         $bold_word = $Result;
echo "<b>Bold:</b>".$bold_word." <br> ";
//        $arrWord[$cnt] = escapestring($cur->surface);
        $cnt++;
        break;
    }
    //$blg_body = str_replace ($bold_word,'<b>'.$bold_word.'</b>',$blg_body);
//------------------------------------------------


        $objUtil = new utl_markov();
        $blg_body = $objUtil->summarize($blg_body, 1);

        echo "【変換後】<br>";
        echo blg_body_cnv($blg_body);

    }
}
    $objHtml = new cls_htmL_index('./../');
    $objHtml->main();
?>


