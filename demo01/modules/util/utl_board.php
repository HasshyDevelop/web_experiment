<?php
//-----------------------------------------
//-----------------------------------------
class utl_board {
    private $board_id;
    private $board_name;
    private $board_url;
    private $thread_txt;

    //-----------------------------------------
    //変数クリア
    //-----------------------------------------
    function init($board_id, $board_name,$board_url){
        $this->board_id           = $board_id;
        $this->board_name         = $board_name;
        $this->board_url          = $board_url;
        $this->thread_txt         = $this->board_url.THREAD_TXT_NAME;

//        print '*init START<br>';
//        print "board_id : ".$this->board_id."<br>";
//        print "board_name : ".$this->board_name."<br>";
//        print "thread_txt : ".$this->thread_txt."<br>";
    }

    //-----------------------------------------
    //-----------------------------------------
    function get_subject(){
        //DBオブジェクトを作成
        $dbObj = new db_d_thread();
        //板IDでデータを削除する
        $dbObj->del_with_board_id($this->board_id);

        //txtファイルを開ける
        $thread_list = @fopen($this->thread_txt,'r');

        if($thread_list){
            //ファイルの最後まで読みに行く
            while(!feof($thread_list)){
                //変数初期化
                $dbObj->init();

                //1行ずつ取得
                $line = fgets($thread_list);
                //UTF-8に変換
                $line = mb_convert_encoding($line,'utf8','sjis-win');

                //スレナンバーを取得
                //.dat<>が何文字目か、0から数える
                $thread_id_num = mb_strpos($line,'.dat<>');
                //0番目からスレナンバーの桁分抽出
                $thread_id = mb_substr($line,0,$thread_id_num);

                //レス数を取得
                //------------------
                //「)」が最後に現れる文字が何番目か
                $last = mb_strrpos($line,')')-1;
                //「 (」が最後に現れる文字が何番目か
                $first = mb_strrpos($line,' (')+1;
                //レス数の桁
                $n = $last-$first;
                //スレナンバー抽出
                $num = mb_substr($line,$first+1,$n);

                //スレ名を取得
                //スレ名の文字数、7は「.dat<>」の文字数と0番目の1文字
                $name = $first-7-$thread_id_num;
                //6は「.dat<>」の文字数
                $thread_name = mb_substr($line,$thread_id_num+6,$name);

                $thread_date = date("Y-m-d H:i:s",$thread_id);

                $dat_url = $this->board_url."dat/".$thread_id.".dat";

                //少ないレス数は省く
                if($num >= MIN_THREAD){
                    //
                    $dbObj->set_board_id($this->board_id);
                    $dbObj->set_board_name($this->board_name);
                    $dbObj->set_thread_id($thread_id);
                    $dbObj->set_thread_name($thread_name);
                    $dbObj->set_thread_date($thread_date);
                    $dbObj->set_res_cnt($num);
                    $dbObj->set_dat_url($dat_url);
                    $dbObj->insert();
                }
/*
                print 'スレID：'.$thread_id.'<br />';
                print 'レス数：'.$num.'<br />';
                print 'スレ名：'.$thread_name.'<br />';
                print 'DAT：'.$dat_url.'<br />';
*/
            }
        }else{
            //廃止された板はスルー
//            continue;
        }
        //ファイルを閉める
        fclose($thread_list);
    }
}

?>
