<?php
    require_once 'modules/require.php';
    header("Content-type: text/plain; charset=UTF-8");

    if(isset( $_POST['lst_id'] )) {

        //DBの値を取得
        $m_board = new db_m_board();
        //ソート番号を一旦リセット
        $m_board->sort_no_reset();

        $upd_cnt = 0;
        $upd_sort_no = 0;
        foreach ($_POST['lst_id'] as $upd_id) {
            if($upd_id != ERR_CD_NODATA){
                $upd_sort_no++;
                $upd_cnt++;

                $m_board->sort_no_upd($upd_id, $upd_sort_no);
            }
        }
        print "<script>"."\n";
        print "alert('更新しました。\\n 設定件数：".$upd_cnt."件')"."\n";

        print "location.reload();"."\n";

        print "</script>"."\n";
    }else{
        print "<script>"."\n";
        print "alert('失敗しました。　パラメータ受取エラー')"."\n";
        print "</script>"."\n";
    }
?>
