<?php

class cls_task {

    function exec_main($row){
        //Debug
        print "【m_schedule】"."<br>";
        print $row['schedule_no']."<br>";
        print $row['exec_id']."<br>";
        print $row['memo']."<br>";
        print $row['general_col01']."<br>";
        print $row['general_col02']."<br>";
        print $row['general_col03']."<br>";
        print $row['general_col04']."<br>";
        print $row['general_col05']."<br>";

        $exec_id = $row['exec_id'];

        switch ($exec_id){
        case EXEC_ID_RSS:
            $objUtil = new cls_make_rnk_data();
            $objUtil->main();
            break;

        case EXEC_ID_MAKE_THREAD_STEP1:
            $borad_id = $row['general_col01'];

            $objUtil = new cls_make_thread_data();
            $objUtil->main($borad_id);
            //Debug
            $objUtil->wk_thread_disp();

            break;

        case EXEC_ID_MAKE_THREAD_STEP2:
            $objUtil = new cls_make_thread_data();
            $objUtil->set_sort_cd();
            //Debug
            $objUtil->wk_thread_disp();
            break;

        case EXEC_ID_MAKE_THREAD_STEP3:
            $objUtil = new cls_make_thread_data();
            $objUtil->data_organize();
            //Debug
            $objUtil->wk_thread_disp();
            break;

        default:
            print "exec_id　エラー";
            break;
        }
    }

    function exec_task(){
        $dbTask  = new db_d_task_m_schedule();
        $result = $dbTask->select_task(TASK_ID);

        $new_schedule_no = 0;
        while ($row = $result->fetch_assoc()) {
            $new_schedule_no = $row['schedule_no'];
        }

        //d_task が検索でなかった時は新規作成
        if($new_schedule_no == 0){
            $new_schedule_no = 1;

            $dbTask->set_task_id(TASK_ID);
            $dbTask->set_task_schedule_no($new_schedule_no);
            $dbTask->insert_task();
        }else{
            $new_schedule_no++;
        }

//Debug
$new_schedule_no = 7;

        //
        $exec_flg = false;
        $result = $dbTask->select_schedule_with_no($new_schedule_no);
        while ($row = $result->fetch_assoc()) {
            $this->exec_main($row);
            $exec_flg = true;
        }

        if($exec_flg == false){
            //スケジュールデータが見つからなっかた時は
            //前回が最後だったので一番最初に戻ってやり直す
            $new_schedule_no = 1;
            $result = $dbTask->select_schedule_with_no($new_schedule_no);
            while ($row = $result->fetch_assoc()) {
                $this->exec_main($row);
                $exec_flg = true;
            }
        }

        if($exec_flg){
            $dbTask->upd_task_schedule($new_schedule_no);
        }

    }
}

?>

