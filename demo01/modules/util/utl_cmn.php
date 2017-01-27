<?php
//-----------------------------------------
//-----------------------------------------
class utl_cmn {

    //-----------------------------------------
    //文字列を暗号化
    //今後の事を考えて関数化
    //-----------------------------------------
    function str_to_hash($value){
        $hashed_passwd = password_hash($value,PASSWORD_DEFAULT);
        return $hashed_passwd;
    }

    //-----------------------------------------
    //暗号化文字列を比較
    //今後の事を考えて関数化
    //-----------------------------------------
    function hash_verify($value, $hash){
        $result = false;

        if (password_verify($value, $hash)) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }
}

?>
