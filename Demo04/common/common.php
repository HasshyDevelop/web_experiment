<?php

/** @mainpage
 * Yahoo!ショッピングWeb APISDK共通関数
 */

/**
 * @file
 * @brief Yahoo!ショッピングWeb APISDK共通関数
 *
 * Yahoo!ショッピングWeb APISDKで、共通で使用する設定・関数を集めたファイルです。
 *
 * PHP version 5
 *
 */

/**
 * @brief アプリケーションID
 * 
 * Yahoo! JAPANが提供するWeb APIを利用するアプリケーションには、アプリケーションIDが必要です。
 * Yahoo!デベロッパーネットワークで取得したアプリケーションIDを設定してください。
 * アプリケーションIDの取得については
 * http://e.developer.yahoo.co.jp/webservices/register_application
 * をご覧ください。
 * 
 * @var string
 */
$appid = "dj0zaiZpPWh5bFdWYmJrM2ZIeiZzPWNvbnN1bWVyc2VjcmV0Jng9Mzk-";//取得したアプリケーションIDを設定

/**
 * @brief カテゴリーID一覧
 *
 * 商品カテゴリの一覧です。
 * キーにカテゴリID、値にカテゴリ名が入っています。
 * @var array
 */
$categories = array(
                    "1" => "すべてのカテゴリから",
                    "13457"=> "ファッション",
                    "2498"=> "食品",
                    "2500"=> "ダイエット、健康",
                    "2501"=> "コスメ、香水",
                    "2502"=> "パソコン、周辺機器",
                    "2504"=> "AV機器、カメラ",
                    "2505"=> "家電",
                    "2506"=> "家具、インテリア",
                    "2507"=> "花、ガーデニング",
                    "2508"=> "キッチン、生活雑貨、日用品",
                    "2503"=> "DIY、工具、文具",
                    "2509"=> "ペット用品、生き物",
                    "2510"=> "楽器、趣味、学習",
                    "2511"=> "ゲーム、おもちゃ",
                    "2497"=> "ベビー、キッズ、マタニティ",
                    "2512"=> "スポーツ",
                    "2513"=> "レジャー、アウトドア",
                    "2514"=> "自転車、車、バイク用品",
                    "2516"=> "CD、音楽ソフト",
                    "2517"=> "DVD、映像ソフト",
                    "10002"=> "本、雑誌、コミック"
                    );
/**
 * @brief ソート方法一覧
 *
 * 検索結果のソート方法の一覧です。
 * キーに検索用パラメータ、値にソート方法が入っています。
 * @access private
 * @var array
 * 
 */
$sortOrder = array(
                   "-score" => "おすすめ順",
                   "+price" => "商品価格が安い順",
                   "-price" => "商品価格が高い順",
                   "+name" => "ストア名昇順",
                   "-name" => "ストア名降順",
                   "-sold" => "売れ筋順"
                   );

/**
 * @brief 特殊文字を HTML エンティティに変換する
 *
 * これは、htmlspecialchars()を使いやすくするための関数です。
 * htmlspecialchars() http://jp.php.net/htmlspecialcharsより
 *   文字の中には HTML において特殊な意味を持つものがあり、
 *   それらの本来の値を表示したければ HTML の表現形式に変換してやらなければなりません。
 *   この関数は、これらの変換を行った結果の文字列を返します。
 *
 *   '&' (アンパサンド) は '&amp;' になります。
 *   ENT_QUOTES が設定されている場合のみ、 ''' (シングルクオート) は '&#039;'になります。
 *   '<' (小なり) は '&lt;' になります。
 *   '>' (大なり) は '&gt;' になります。
 *   ''' (シングルクオート) は '&#039;'になります。
 *
 * echo h("<>&'\""); //&lt;&gt;&amp;&#039;&quotと出力します。
 *
 * @param string $str 変換したい文字列
 * 
 * @return string html用に変換した文字列
 * 
 */
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

?>