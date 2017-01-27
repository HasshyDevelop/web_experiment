    <script>
        $(document).ready(function(){
            $('#btn_login').on("click",function(){

                var user_id   = $('#user_id').val();
                var user_pass = $('#user_passwd').val();

                $.post("login.php",
                    {"id": user_id, "pass": user_pass },
                    function(response){
                        $("#login_section").html(response);
                    },
                    "html"
                );

            });
        });
    </script>
<div class="section_login">
    <form method="post" action="/config/login" name="login_form" id="login_form">
        <div id="yregloginfield">
            <div class="placeholderWrp">
                <span class="placeholder" id="phid">ユーザID</span><br>
                <input name="login" id="user_id" value="" class="yreg_ipt c01bd yjM" type="text">
            </div>
            <div class="placeholderWrp">
                <span class="placeholder" id="phpw">パスワード</span><br>
                <input name="passwd" id="user_passwd" value="" class="yreg_ipt c01bd yjM" type="password">
            </div>
            <input type="button" value="ログイン" class="btnLogin" id="btn_login">
            <div class="new_regist"><a href="user_regist.php">[新規登録]</a></div>
        </div>
    </form>
    <div id="login_section"></div>
</div>

