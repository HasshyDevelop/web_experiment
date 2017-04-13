<?php
    require_once './modules/require.php';



    //POSTされた値
    $apikey = 'YTQ2NjMwMTdjNGQ3';
    //暗号化・復元用のIVキーを作成します。これ大事
    //指定した暗号モードの組み合わせに属する IV の大きさを調べます
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_CBC);  
    //暗号モードに対するIVのサイズに合わせたキーを生成します
    $iv = mcrypt_create_iv($iv_size, MCRYPT_DEV_RANDOM);
    //暗号化・復元用のソルトを指定します。これは漏れたらダメなやつです
    $passphrase = 'HONDA RA271';
 
    //暗号化を実施
    $sys_apikey = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $passphrase, $apikey, MCRYPT_MODE_CBC, $iv);


    try{
        //
        $strSQL  = "INSERT INTO m_sys VALUES (";
        $strSQL  = $strSQL . " 'sys' ";
        $strSQL  = $strSQL . ",'".$apikey."'";
        $strSQL  = $strSQL . ",'https://allcoupon.jp/api-v1/coupon?output=xml'";
        $strSQL  = $strSQL . ") ";
        //DEBUG
        //print $strSQL."<BR><BR>";
        if(!$result = $G_MY_SQLI->query($strSQL)){
           $strErr = '<b>SQL ERR </b>'.$fcName.' : '.$G_MY_SQLI->error.'<br>'.$strSQL;
           print $strErr;
//                Die();
        } else {
            echo "m_sys OK <br>";
        }

        echo "<b>終了</b><br>";
    } catch (Exception $e) {
        $strErr = '<b>OTHER ERR </b>'.$fcName.' : '.$e->getMessage().'<br>'.$strSQL;
        print $strErr;
    }

?>


