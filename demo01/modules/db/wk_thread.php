<?php
    //-----------------------------------------
    //-----------------------------------------
    function wk_thread_clear(){
        global $G_MY_SQLI;
        
        try{
            //全削除
            $strSQL  = "TRUNCATE TABLE wk_thread";

            if(!$result = $G_MY_SQLI->query($strSQL)){
                $strErr = 'CMN_GetSysDate : '.Mysql_Error().'::'.$strSQL;
                print $strErr;
                Die();
            }

        } catch (Exception $e) {
            $strErr = 'fcTruncThreadTbl:'.$e->getMessage();
            print $strErr;
        }
    }

    //-----------------------------------------
    //-----------------------------------------
    function wk_thread_ins($wk_thread){
        global $G_MY_SQLI, $G_TODAY;
        
        try{
            //
            $strSQL  = "INSERT INTO wk_thread VALUES(";

            $strSQL  = $strSQL . " '".$wk_thread['thread_num']."'";
            $strSQL  = $strSQL . ",'".$wk_thread['res_number']."'";
            $strSQL  = $strSQL . ",'".$wk_thread['post_name']."'";
            $strSQL  = $strSQL . ",'".$wk_thread['post_mail']."'";
            $strSQL  = $strSQL . ",'".$wk_thread['post_datetime']."'";
            $strSQL  = $strSQL . ",'".$wk_thread['post_txt1']."'";
            $strSQL  = $strSQL . ",'".$wk_thread['post_txt2']."'";
            $strSQL  = $strSQL . ",'".$wk_thread['post_txt3']."'";
            $strSQL  = $strSQL . ",'".$wk_thread['post_txt4']."'";
            $strSQL  = $strSQL . ",'".$wk_thread['post_txt5']."'";
            $strSQL  = $strSQL . ",'".$wk_thread['disp_flg']."'";
            $strSQL  = $strSQL . ",'".$G_TODAY."'";

            $strSQL  = $strSQL . "); ";

            if(!$result = $G_MY_SQLI->query($strSQL)){
                $strErr = 'wk_thread_ins : '.Mysql_Error().'::'.$strSQL;
                print $strErr;
                Die();
            }

        } catch (Exception $e) {
            $strErr = 'wk_thread_ins Ex:'.$e->getMessage();
            print $strErr;
        }
    }

    //-----------------------------------------
    //-----------------------------------------
    function wk_thread_select_disp(){
        global $G_MY_SQLI;
        
        try{
            //全削除
            $strSQL  = "";
            $strSQL  = $strSQL."SELECT  ";
            $strSQL  = $strSQL." thread_num";
            $strSQL  = $strSQL.",res_number";
            $strSQL  = $strSQL.",post_name";
            $strSQL  = $strSQL.",post_mail";
            $strSQL  = $strSQL.",post_datetime"; 
            $strSQL  = $strSQL.",CONCAT(post_txt1, post_txt2, post_txt3, post_txt4, post_txt5) AS post_txt";
            $strSQL  = $strSQL." FROM ";
            $strSQL  = $strSQL." wk_thread";
            $strSQL  = $strSQL." WHERE ";
            $strSQL  = $strSQL." disp_flg = 1";
            $strSQL  = $strSQL." ORDER BY  res_number, thread_num";

            if(!$result = $G_MY_SQLI->query($strSQL)){
               $strErr = 'wk_thread_select_disp : '.Mysql_Error().'::'.$strSQL;
               print $strErr;
               //Die();
                return NULL;
            }

            return $result;

        } catch (Exception $e) {
            $strErr = 'wk_thread_select_disp:'.$e->getMessage();
            print $strErr;
        }
    }
?>
