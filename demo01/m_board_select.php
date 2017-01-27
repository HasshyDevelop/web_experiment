<?php
    require_once 'modules/require.php';

    //ヘッダー出力
    hrml_head();

    //TOP メニュー
    html_top_menu();

    //コンテンツ
    contents_start();
    html_left_contents();

    $select_board_id =  isset($_GET['board_id']) ? htmlspecialchars($_GET['board_id']) : null;

    print "<div id=\"main\">";
    print "<h2>ID選択</h2>";

    //ID選択エリア描画
    id_select_table();

    if($select_url != ""){
        //ID選択エリア描画
        thread_select_table();
    }
    print "</div>";

    //コンテンツ
    html_right_contents();
    contents_end();

    //フッター出力
    hrml_foot();

    //DB クローズ
    $G_MY_SQLI->close();

//--------------------------------
//Private Function
//--------------------------------
    //ID選択エリア描画
    function id_select_table(){
        global $select_board_id, $select_name, $select_url;

        //DBの値を取得
        $m_board = new db_m_board();
        $result = $m_board->select_all(ODR_SORT);

        $select_name = "";
        $select_url  = "";
?>
        <form method="GET" action="">
        <table>
            <tr>
                <td>
                    <select name="board_id" size="1" style="width: 300px;">
                    <?php
                        while ($row = $result->fetch_assoc()) {
                            print "<option value=\"".$row['board_id']."\"";
                            if ($select_board_id == $row['board_id']) {
                                print " selected";
                                //検索回数を減らすため選択されたデータのURLを退避
                                $select_name = $row['board_name'];
                                $select_url  = $row['board_url'];
                            }
                            print ">"."\n";
                            if($row['sort_no'] != $m_board::sort_no_default){
                                print "☆　";
                            } else {
                                print "　　";
                            }
                            print $row['board_name'];
                            print "</option>"."\n";
                        }
                    ?>
                    </select>
                </td>
                <td>&nbsp;&nbsp;&nbsp;&nbsp</td>
                <td>
                    <input type="submit" value="選択" style="width: 100px;">
                </td>
            </tr>
        </table>
        </form>
<?php
    }

    //ID選択エリア描画
    function thread_select_table(){
        global $select_board_id, $select_name, $select_url;

        //タイトル
        print "<br>";
        print "<h2>".$select_board_id.': '.$select_name."&nbsp;&nbsp;&nbsp;&nbsp;".$select_url."</h2>";

        $obj_util = new utl_board();
        $obj_util->init($select_board_id, $select_name, $select_url);
        //データ作成
        $obj_util->get_subject();

        $d_threead = new db_d_thread();
        $result = $d_threead->select_with_board_id($select_board_id);

        print "<div style=\"width: 100%; border: 0px; height:600px; overflow:auto; overflow-x: hidden;\">"."\n";
        while ($row = $result->fetch_assoc()) {
            print "日付：";
            print $row['thread_date_ymd'];
            print "&nbsp;&nbsp;&nbsp;&nbsp;";
            print "レス数：";
            print $row['res_cnt'];
            print "<br>";
            print $row['thread_id'];
            print "：";
            print $row['thread_name']."<br>";
  
            print "<a href='";
            print "thread_lst.php";
            print "?board_id=".$select_board_id;
            print "&thread_id=".$row['thread_id'];
            print "&dat_url=".$row['dat_url'];

//            print "&board_name=".DB_INS_STR_CONV($select_name);
            print "' target='_blank'>";
            print $row['dat_url'];
            print "</a>";
            print "<br>";
            print "<hr>";
        }
        print "</div>"."\n";
    }

?>
