<?php
    require_once './modules/require.php';
    require_once '../modules/cls_html.php';


class cls_htmL_index extends cls_html
{
    //OVER RIDE
    public function page_contents()
    {
//        echo "オーバーライド　OK";
        $string='平均寿命が年々延びている長寿大国日本。しかし、死ぬまで健康でいられるわけでもなく、「太った」「疲れやすい」など体の悩みは尽きないものだ。いったい我々はこの先どのように生きたら健康でいられるのだろうか。そこで今回、各識者の意見を参考に「不健康になる」ランキングを作成。果たして、あなたの健康状態は大丈夫？

＜こんな部屋はストレスが溜まるワースト5＞

1位　部屋がモノで溢れている
2位　外出が億劫な物件に住む
3位　部屋の日当たりが悪い
4位　紙ゴミがやたらと多い
5位　人を部屋に入れていない

◆ストレスが部屋にモノを溜め込み、その悪循環で心は蝕まれていく……

「部屋の状態はその人のストレス状態を表し、悪化していくごとにさらに健康状態も蝕まれていくので悪循環なんです」

　とは、遺品整理アドバイザー・上東丙唆祥氏。昨今増え続けている40代の自室での孤独死のケースを数多く見てきた。死の理由は、自殺や病気による発作などそれぞれだが、共通しているのは健康状態が悪い人間の部屋は、モノが多くなってしまうという。部屋にモノが溢れると、かえってストレスになるのは実感ある人も多かろう。

「また、住む物件も影響してきます。外出が億劫になるようなエレベーターのない団地の5階などです。外出しないばかりか、ゴミ捨ても頻繁にやらない。おまけにレトルトなどの保存食を買い溜めるなど、健康に悪い食習慣も生み出します。さらに、日当たりが悪ければ、それだけで人間のバイオリズムも大きく狂わせ、酷ければ心も病んでしまう原因になります」

　さらにそんな部屋で日夜、便利で得する情報収集のために書籍や雑誌を読み漁り、積ん読状態に。

「情報のあるものを衝動的に消費してしまう行動は社会的不安の表れです。40代は社会的責任も重い年齢なのも関係しています。でも結局その足りないものを埋める行動が自分を苦しめる。もし今の自分に物足りなさを感じるなら、まずは今あるモノを捨ててみてほしい。僕の経験ではモノが少ない部屋で孤独死する人はいません」

　もし、自分が死んだらいったい誰が後始末をしてくれるのだろうか。あなたの部屋が終の住処にならないためにも、不健康のサインを見逃してはいけない。

＜どっちが不健康？＞

●団地の上層階vsアパートの1階

正解は団地の上層階。昭和40年代に建てられた団地のほとんどにはエレベーターがなく、上層階に行くほど孤立しがち。外出しやすく人の目を意識するアパートの1階住まいのほうが健康だ

【上東丙唆祥氏】
遺品整理アドバイザー。遺品整理フランチャイズチェーン「e品整理」代表。遺品整理、遺品処理、生前整理、不要品回収（処理）なども行う';

        $objUtil = new utl_markov();
//        $objUtil->main();

print "【原文】<br>";
print $string;
print "<br><br>";

print "【マルコフ１】<br>";
echo $objUtil->summarize($string, 1); // 1を渡すか2を渡すかでアルゴリズムが変わる。デフォルトは1。1でも2でもない場合はなにもしません。
print "<br><br>";

print "【マルコフ２】<br>";
echo $objUtil->summarize($string, 2);
print "<br><br>";

print "【マルコフ２】<br>";
echo $objUtil->summarize($string, 3);
print "<br><br>";
    }
}
    $objHtml = new cls_htmL_index('./../');
    $objHtml->main();
?>

