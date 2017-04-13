<?php

class cls_make_board {

    private $board_url;
    private $read_url;
    private $dat_url;

    function set_server_url($url,$board_id){
        $base_url = $url;

        if(mb_substr($base_url, -1) == "/"){
            $base_url = substr($base_url, 0 ,-1);
        }

        $last_pos = strrpos($base_url, "/") + 1;
        $base_url = substr($base_url, 0, $last_pos);

        $this->board_url    = $base_url.$board_id;
        $this->read_url     = $base_url."test/read.cgi/".$board_id."/".CNV_STR_THREAD_ID;
        $this->dat_url      = $base_url.$board_id."/dat/".CNV_STR_THREAD_ID.".dat";
    }

    function main(){
        //板一覧を読み込む
        $html=file_get_contents(URL_BBSALL);
        //UTF-8に変換
        $html=mb_convert_encoding($html,'utf8','sjis-win');
        //リンクを配列に入れる
        preg_match_all('/<A HREF=.*>.*<\/A>/',$html,$links);

        //多次元配列をシングルに
        $links=$links[0];

        $objDB = new db_m_board();
        //テーブルをクリア
        $objDB->truncate();

        //2ch.scのリンクを抽出する
        $i=0;
        foreach($links as $link){
            if(preg_match('{<A HREF=http:\/\/(.*).2ch.sc\/(.*)\/>}',$link)){
                //URL部分とリンクの文字を取得　$res[$i][0]にURL　$res[$i][1]に板名
                if(preg_match_all('/<A HREF=(\S*)>(.*)<\/A>/',$link,$match,PREG_SET_ORDER)){
                    $res[$i][0]=$match[0][1];
                    $res[$i][1]=$match[0][2];

                    $link = $res[$i];

                    $board_name = $link[1];//板名
                    $board_url  = $link[0];//URL
                    //板IDだけを独立して取得
                    preg_match('{2ch.sc/(.*)/$}',$board_url,$ch);
                    $board_id = $ch[1];

                    //各URL取得
                    $this->set_server_url($board_url,$board_id);

                    //変数初期化
                    $objDB->init();
                    $objDB->set_board_id($board_id);
                    $objDB->set_board_name($board_name);
                    $objDB->set_board_url($this->board_url);
                    $objDB->set_read_url($this->read_url);
                    $objDB->set_dat_url($this->dat_url);

                    //DB 更新
                    $objDB->duplicate_insert();

                    print '<BR>';
                    print 'ID：'.$board_id.'&#13;';
                    print '<BR>';
                    print 'Name：'.$board_name.'&#13;';
                    print '<BR>';
                    print 'URL：'.$board_url.'&#13;';
                    print '<BR>';
                    print 'BOARD URL：'.$this->board_url.'&#13;';
                    print '<BR>';
                    print 'READ URL：'.$this->read_url.'&#13;';
                    print '<BR>';
                    print 'DAT URL：'.$this->dat_url.'&#13;';

                    print '<BR>';

                    $i++;
                }
            }
        }
    }
}

?>

