<?php
    require_once 'modules/require.php';

    //プライベート固定値
    $MODE_REGIST = "regist";

    class prm_user {
        public $value;
        public $bgcolor;
        public $err_msg;

        function __construct() {
            $this->value   = "";
            $this->bgcolor = "#FFFFFF";
            $this->err_msg = "";
        }

        function init(){
            global $G_TODAY;

            $this->user_id      = "";
            $this->user_name    = "";
            $this->password     = "";
            $this->update_date  = $G_TODAY;;
        }
    }

    //新規登録
    $G_LOGIN_MODE = LOGIN_NEW;

    //ヘッダー出力
    hrml_head();

    //TOP メニュー
    html_top_menu();

    //コンテンツ
    contents_start();
    html_left_contents();

    //パラメータ受取
    $mode = isset($_POST['mode']) ? htmlspecialchars($_POST['mode']) : null;

    $usr_id = new prm_user();
    $usr_id->value = isset($_POST['user_id']) ? htmlspecialchars($_POST['user_id']) : null;

    $usr_name = new prm_user();
    $usr_name->value = isset($_POST['nickname']) ? htmlspecialchars($_POST['nickname']) : null;

    $usr_pass = new prm_user();
    $usr_pass->value = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : null;

    $usr_pass_cnf = new prm_user();
    $usr_pass_cnf->value = isset($_POST['password_conf']) ? htmlspecialchars($_POST['password_conf']) : null;

    if($mode == $MODE_REGIST){
        //パラメータの入力チェック
        if(prm_check()){
            //データ作成
            data_ins();
            html_regist_ok();
        }else{
            //入力エラー
            html_main();
        }
    }else{
        html_main();
    }

    //コンテンツ
    html_right_contents();
    contents_end();

    //フッター出力
    hrml_foot();

    //DB クローズ
    $G_MY_SQLI->close();

    //メインHTML
    function html_main(){
        global $MODE_REGIST;
        global $status;
        global $usr_id,$usr_name,$usr_pass,$usr_pass_cnf;
?>
    <div id="main" >
    <h2>新規登録</h2>
    <script>
        $(document).ready(function(){
            $('#btn_submit').on("click",function(){
                if(!confirm('登録しますか？')){
                    /* キャンセルの時の処理 */
                    return false;
                }else{
                    /*　OKの時の処理 */
                     $('#regist_form').submit();
                }
            });
        });
    </script>

    <form method="POST" action="" id="regist_form">
        <input type="hidden" name="mode" value="<?=$MODE_REGIST ?>">
        <fieldset class="form-input-required" style="padding-bottom:0;background:<?=$usr_id->bgcolor ?>">
            <div class="form-input-field">
                <li>
                    <label class="form-input-label">ユーザID
                                                    <br><span>「半角英数字」4文字以上で入力してください</span>
                                                    <br><span style="color:#ff0000;"><?=$usr_id->err_msg ?></span>
                    </label>
                     <input type="text" name="user_id" class="form-textfield" size="10" value="<?=$usr_id->value ?>" />
                </li>
            </div>
        </fieldset>

        <fieldset class="form-input-required" style="padding-bottom:0;background:<?=$usr_name->bgcolor ?>;">
            <div class="form-input-field" >
                <li >
                    <label class="form-input-label">ニックネーム
                                                    <br><span>半角英数字20文字以内 ※ご登録後の変更はできません</span>
                                                    <br><span style="color:#ff0000;"><?=$usr_name->err_msg ?></span>
                    </label>
                    <input type="text" name="nickname" class="form-textfield" size="20" value="<?=$usr_name->value ?>" />
                </li>
            </div>
        </fieldset>

        <fieldset class="form-input-required" style="padding-bottom:0;background:<?=$usr_pass->bgcolor ?>;">
            <div class="form-input-field">
                <li>
                    <label for="password" class="form-input-label">パスワード
                                                                   <br><span>「半角英数字」「.」「-」「_」を使用し、8文字以上で入力してください</span>
                                                                   <br><span style="color:#ff0000;"><?=$usr_pass->err_msg ?></span>
                    </label>
                    <input type="password" name="password" class="form-textfield" size="20" value="<?=$usr_pass->value ?>" />
                </li>
            </div>
        </fieldset>

        <fieldset class="form-input-required" style="padding-bottom:0;background:<?=$usr_pass_cnf->bgcolor ?>;">
            <div class="form-input-field">
                <li> 
                    <label for="password" class="form-input-label">パスワード（確認）
                                                                   <br><span>上記パスワードをもう一度入力して下さい。</span>
                                                                   <br><span style="color:#ff0000;"><?=$usr_pass_cnf->err_msg ?></span>
                    </label>
                    <input type="password" name="password_conf" class="form-textfield" size="20" value="<?=$usr_pass_cnf->value ?>" />
                </li>
            </div>
        </fieldset>

        <hr>

        <div class="form-input-field" style="text-align: center;width:100%">
            <input type="button" class="btnRegist" id="btn_submit" value="登録" />
        </div>

    </div>
<?php
    }

    //登録完了
    function html_regist_ok(){
        global $MODE_REGIST;
        global $status;
        global $usr_id,$usr_name,$usr_pass,$usr_pass_cnf;
?>
        <div id="main" >
        <h2>新規登録</h2>
        <br><br>
        <h1>登録完了</h1>

    </div>
<?php
    }


    function prm_check(){
        global $usr_id,$usr_name,$usr_pass,$usr_pass_cnf;

        $bol_result = true;

        if($usr_id->value == ""){
            $usr_id->bgcolor = "#FFDDDD";
            $usr_id->err_msg = "必須項目が入力されていません。";

            $bol_result = false;
        }elseif(strlen($usr_id->value) < 4){
            $usr_id->bgcolor = "#FFDDDD";
            $usr_id->err_msg = "短すぎます。";

            $bol_result = false;
        }


        if($usr_name->value == ""){
            $usr_name->bgcolor = "#FFDDDD";
            $usr_name->err_msg = "必須項目が入力されていません。";

            $bol_result = false;
        }

        if($usr_pass->value == ""){
            $usr_pass->bgcolor = "#FFDDDD";
            $usr_pass->err_msg = "必須項目が入力されていません。";

            $bol_result = false;
        }elseif(strlen($usr_pass->value) < 8){
            $usr_pass->bgcolor = "#FFDDDD";
            $usr_pass->err_msg = "短すぎます。";

            $bol_result = false;
        }

        if($usr_pass->value == ""){
            $usr_pass->bgcolor = "#FFDDDD";
            $usr_pass->err_msg = "必須項目が入力されていません。";

            $bol_result = false;
        }

        if($usr_pass_cnf->value == ""){
            $usr_pass_cnf->bgcolor = "#FFDDDD";
            $usr_pass_cnf->err_msg = "必須項目が入力されていません。";

            $bol_result = false;
        }

        if($usr_pass->value != $usr_pass_cnf->value){
            $usr_pass_cnf->bgcolor = "#FFDDDD";
            $usr_pass_cnf->err_msg = "パスワードは同じものを入力してください。";

            $bol_result = false;
        }

        if($bol_result == false){
            return $bol_result;
        }

        $dbObj = new db_m_user();
        $result = $dbObj->select_with_id($usr_id->value);
        while ($row = $result->fetch_assoc()) {
            $usr_id->bgcolor = "#FFDDDD";
            $usr_id->err_msg = "既に使用されています。";

            $bol_result = false;
            return $bol_result;
        }

        return $bol_result;
        $dbObj = NULL;
    }

    function data_ins(){
        global $usr_id,$usr_name,$usr_pass,$usr_pass_cnf;

        $dbObj  = new db_m_user();
        $utlCmn = new utl_cmn();

        $dbObj->set_user_id($usr_id->value);
        $dbObj->set_user_name($usr_name->value);
        $dbObj->set_password($utlCmn->str_to_hash($usr_pass->value));
        $dbObj->insert();
    }
?>
