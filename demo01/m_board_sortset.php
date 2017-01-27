<?php
    require_once 'modules/require.php';

    //ヘッダー出力
    hrml_head();

    //TOP メニュー
    html_top_menu();

    //コンテンツ
    contents_start();
    html_left_contents();

    print "<div id=\"main\" >";
    print "<h2>ソート設定</h2>";
//    print "<h3></h3>";

    //DBの値を取得
    $m_board = new db_m_board();
    $nosort_result  = $m_board->select_no_sortno(ODR_BOARD);
    $sort_result    = $m_board->select_sortno(ODR_SORT);

    //リストボックステーブルの描画
    make_select_tbl();


    print "</div>";

    //コンテンツ
    html_right_contents();
    contents_end();

    //フッター出力
    hrml_foot();

    //DB クローズ
    $G_MY_SQLI->close();

    //
    function fill_space_right($str_value, $space_cnt){
        $strCnt = mb_strlen($str_value);
        
        $strResult = $str_value;
        $i = 1;
        while($space_cnt >= ($strCnt + $i)){
//            $strResult = $strResult."&nbsp;";
            $strResult = $strResult.":";
            $i++;
        }
        return $strResult;
    }

    function make_select_tbl(){
        global $nosort_result, $sort_result;
?>
        <script>
         $(document).ready(function(){
            $('#btn_add').on("click",function(){
                $('#board_to').append($('#board_from option:selected'));
                check();
            });
            $('#btn_rev').on("click",function(){
                $('#board_from').append($('#board_to option:selected'));
                check();
            });

            function check(){
                var flag = 0;
                $('#board_from option').each(function(){
                    flag += parseInt($(this).val(),10);
                });
            }

            function select_move(mode){
                var select_val = $("#board_to option:selected").val();
                var select_txt = $("#board_to option:selected").text();
                var select_idx = $("#board_to").prop("selectedIndex");
                var new_idx = 0;
                var opt_max = $('#board_to option').length;

                if(select_val == null){
                    return;
                }

                if(mode == 'up'){
                    new_idx = select_idx - 1;
                    if(new_idx < 0){
                        new_idx = 0;
                    }
                }else{
                    new_idx = select_idx + 1;
                    if(new_idx > (opt_max - 1)){
                        new_idx = opt_max;
                    }
                }

                var board_lst = $('#board_to').children();
                var ins_val = [];
                var ins_txt = [];

                for (var i=0; i < board_lst.length; i++) { 

                    if(i != select_idx) {
                        //UPは前判断
                        if(i == new_idx && mode == 'up'){
                            ins_val.push(select_val);
                            ins_txt.push(select_txt);
                        }

                        ins_val.push(board_lst.eq(i).val());
                        ins_txt.push(board_lst.eq(i).text());

                        //DWNは後判断
                        if(i == new_idx && mode == 'dwn'){
                            ins_val.push(select_val);
                            ins_txt.push(select_txt);
                        }

                    } else {
                        if((new_idx == 0 && select_idx == 0) || new_idx == opt_max){
                            ins_val.push(select_val);
                            ins_txt.push(select_txt);
                        }
                    }
                }

                //全ての要素を削除する場合
                $('#board_to').children().remove();

                for (var i=0; i < ins_val.length; i++) { 
                    $("#board_to").append($("<option>").val(ins_val[i]).text(ins_txt[i]));
                }

                //選択を戻す
                $("#board_to").val(select_val);
            }

            $('#btn_up').on("click",function(){
                select_move('up');
            });

            $('#btn_dwn').on("click",function(){
                select_move('dwn');
            });

            $('#btn_submit').on("click",function(){
                 //POSTメソッドで送るデータを定義します var data = {パラメータ名 : 値};
                var para_data = {id_lst : $('#board_to').children()};

                var board_lst = $('#board_to').children();
                var lst_id = [];

                for (var i=0; i < board_lst.length; i++) { 
                    lst_id.push(board_lst.eq(i).val());
                }

                if(lst_id.length == 0){
                    lst_id.push("<?=ERR_CD_NODATA ?>");
                }

                $.post(
                    "m_board_sort_res.php",
                    {"lst_id[]": lst_id},
                    function(response){
                        $("#response_result").html(response);
                    },
                    "html"
                );
            });
        });

        </script>

        <table>
        <tr>
            <td><h3>未設定</h3></td>
            <td></td>
            <td><h3>設定済</h3></td>
        </tr>
        <tr>
            <td>
                <select id="board_from" size="10" style="width: 200px; height: 300px;" >
                <?php
                    while ($row = $nosort_result ->fetch_assoc()) {
                        echo "<option value=\"".$row['board_id']."\"";
                        print ">"."\n";
                        print $row['board_name'];
                        print "</option>"."\n";
                    }
                ?>
                </select>
            </td>
            <td valign="top">
                <br>
                <input type="button" id="btn_add" value="→" style="width: 50px;">
                <br><br><br>
                <input type="button" id="btn_rev" value="←" style="width: 50px;">
            </td>
            <td>
                <select id="board_to" size="10" style="width: 200px; height: 300px;" >
                <?php
                    while ($row = $sort_result ->fetch_assoc()) {
                        echo "<option value=\"".$row['board_id']."\"";
                        print ">"."\n";
                        print $row['sort_no']."  :  ";
                        print $row['board_name'];
                        print "</option>"."\n";
                    }
                ?>
                </select>
            </td>
            <td valign="top">
                <br>
                <input type="button" id="btn_up" value="↑" style="width: 25px;height:50px;" onclick="optionMove(-1)">
                <br><br><br>
                <input type="button" id="btn_dwn" value="↓" style="width: 25px;height:50px;" onclick="optionMove(-1)">
            </td>
            <td valign="top" align="center" style="width: 200px;">
                <BR><BR>
                <input type="button" id="btn_submit" value="更新" style="width: 150px; height: 50px;">
            </td>
        </tr>
        </table>

        <div id="response_result"></div>
<?php
    }
?>
