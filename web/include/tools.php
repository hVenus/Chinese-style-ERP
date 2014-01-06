<?php 

function add_log( $TYPE, $REMARK, $OPERATOR ){
    global $connection;
    $CUR_TIME = date( "Y-m-d H:i:s", time( ) );
    $USER_IP = get_client_ip( );
    if ( $TYPE == 1 ){
        $query = "update USER set LAST_VISIT_IP='".$USER_IP."' where USER_ID='{$OPERATOR}'";
        exequery( $connection, $query );
    }
    $REMARK = str_replace( "'", "\\'", $REMARK );
    $REMARK = str_replace( "\\\\'", "\\'", $REMARK );
    $query = "insert into SYS_LOG (USER_ID,TIME,IP,TYPE,REMARK) values ('".$OPERATOR."','{$CUR_TIME}','{$USER_IP}','{$TYPE}','{$REMARK}')";
    exequery( $connection, $query );
    if ( 21 < $TYPE && !find_id( "40,41,", $TYPE ) && get_code_name( $TYPE, "SYS_LOG" ) == "" ){
        $query1 = "INSERT INTO `SYS_CODE` ( `CODE_NO` , `CODE_NAME` , `CODE_ORDER` , `PARENT_NO` , `CODE_FLAG` ) VALUES ('".$TYPE."', '"._( "未知类型" )."', '99', 'SYS_LOG', '1');";
        exequery( $connection, $query1 );
    }
    return $query;
}

function get_client_ip(){
    $ip = "unknown";
    if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")){
        $ip = getenv("HTTP_CLIENT_IP");
    }else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")){
        $ip = getenv("HTTP_X_FORWARDED_FOR");
    }else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")){
        $ip = getenv("REMOTE_ADDR");
    }else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")){
        $ip = $_SERVER['REMOTE_ADDR'];
    }else{
        $ip = "unknown";
    }
    return $ip;
}

function find_id( $STRING, $ID ){
    $STRING = ltrim( $STRING, "," );
    // 参数不能为空,且不能只是个逗号。
    if ( $ID == "" || $ID == "," ){
        return FALSE;
    }
    // 字符串末尾要加逗号
    if ( substr( $STRING, -1 ) != "," ){
        $STRING .= ",";
    }
    // 在 1,2,3,4,5, 中查找 ,3, 首次出现的位置。这里忽略在字符串的开头出现。
    if ( 0 < strpos( $STRING, ",".$ID."," ) ){
        return TRUE;
    }
    // 在 1，2，3，4，5， 中查找 1， 首次出现的位置。这里只管在开头的情况。
    if ( strpos( $STRING, $ID."," ) === 0 ){
        return TRUE;
    }
    // 如果$ID是字符串，且跟$STRING相等，则返回true.
    if ( strstr( $ID, "," ) && $STRING == $ID ){
        return TRUE;
    }
    return FALSE;
}

function td_trim( $STR, $charlist = " ,\t\n\r\x00\x0B" ){
    return trim( $STR, $charlist );
}

function Message( $TITLE, $CONTENT, $STYLE = "", $BUTTONS = array( ) ){
    $WIDTH = strlen( $CONTENT ) * 15 + 140;
    $WIDTH = 500 < $WIDTH ? 500 : $WIDTH;
    if ( $STYLE == "blank" ){
        $WIDTH -= 70;
    }
    if ( $STYLE == "" ){
        if ( $TITLE == _( "错误" ) ){
            $STYLE = "error";
        }else if ( $TITLE == _( "警告" ) ){
            $STYLE = "warning";
        }else if ( $TITLE == _( "停止" ) ){
            $STYLE = "stop";
        }else if ( $TITLE == _( "禁止" ) ){
            $STYLE = "forbidden";
        }else if ( $TITLE == _( "帮助" ) ){
            $STYLE = "help";
        }else{
            $STYLE = "info";
        }
    }
    echo "<table class=\"MessageBox\" align=\"center\" width=\"";
    echo $WIDTH;
    echo "\">\r\n";
    if ( $TITLE != "" ){
        echo "   <tr class=\"head\">\r\n      <td class=\"left\"></td>\r\n      <td class=\"center\">\r\n         <div class=\"title\">";
        echo $TITLE;
        echo "</div>\r\n      </td>\r\n      <td class=\"right\"></td>\r\n   </tr>\r\n";
    }else{
        echo "   <tr class=\"head-no-title\">\r\n      <td class=\"left\"></td>\r\n      <td class=\"center\">\r\n      </td>\r\n      <td class=\"right\"></td>\r\n   </tr>\r\n";
    }
    echo "   <tr class=\"msg\">\r\n      <td class=\"left\"></td>\r\n      <td class=\"center ";
    echo $STYLE;
    echo "\">\r\n         <div class=\"msg-content\">";
    echo $CONTENT;
    echo "</div>\r\n      </td>\r\n      <td class=\"right\"></td>\r\n   </tr>\r\n";
    if ( is_array( $BUTTONS ) && 0 < count( $BUTTONS ) ){
        echo "   <tr class=\"control\">\r\n      <td class=\"left\"></td>\r\n      <td class=\"center\">\r\n";
        foreach ( $BUTTONS as $BUTTON ){
            echo "<a class=\"BigBtn\" href=\"".( $BUTTON['href'] != "" ? str_replace( "\"", "\\\"", $BUTTON['href'] ) : "javascript:;" )."\"";
            if ( $BUTTON['click'] != "" ){
                echo " onclick=\"".str_replace( "\"", "\\\"", $BUTTON['click'] )."\"";
            }
            echo "><span>".$BUTTON['value']."</span></a>&nbsp;&nbsp;";
        }
        echo "      </td>\r\n      <td class=\"right\"></td>\r\n   </tr>\r\n";
    }
    echo "   <tr class=\"foot\">\r\n      <td class=\"left\"></td>\r\n      <td class=\"center\"></td>\r\n      <td class=\"right\"></td>\r\n   </tr>\r\n</table>\r\n";
}

function get_lang_array_new( ){
    global $ROOT_PATH;
    global $MYOA_IS_UN;
    $LANG_ARRAY = array( "zh-CN" => _( "简体中文" ) );
    $LANG_FILE = $ROOT_PATH."lang/language.ini";
    if ( $MYOA_IS_UN != 1 || !file_exists( $LANG_FILE ) )
    {
        return $LANG_ARRAY;
    }
    $ARRAY = parse_ini_file( $LANG_FILE );
    foreach ( $ARRAY as $LANG => $LANG_DESC )
    {
        $LANG = trim( $LANG );
        $LANG_DESC = trim( $LANG_DESC );
        if ( array_key_exists( $LANG, $LANG_ARRAY ) )
        {
            $LANG_ARRAY[$LANG] = $LANG_DESC;
        }
    }
    return $LANG_ARRAY;
}
function get_lang_array( )
{
    global $ROOT_PATH;
    global $MYOA_IS_UN;
    $LANG_ARRAY = array("zh-CN" => _( "简体中文" ));
    $LANG_FILE = $ROOT_PATH."lang/language.ini";
    if ( $MYOA_IS_UN != 1 || !file_exists( $LANG_FILE ) ){
        return $LANG_ARRAY;
    }
    $ARRAY = parse_ini_file( $LANG_FILE );
    foreach ( $ARRAY as $LANG => $LANG_DESC ){
        $LANG = trim( $LANG );
        $LANG_DESC = trim( $LANG_DESC );
        if ( !array_key_exists( $LANG, $LANG_ARRAY ) ){
            $LANG_ARRAY[$LANG] = $LANG_DESC;
        }
    }
    return $LANG_ARRAY;
}

function cacheMenu( ){
    $LANG_ARRAY = get_lang_array( );
    $CACHE_ARRAY = array( );
    global $connection;
    global $ROOT_PATH;
    $query = "SELECT * from SYS_MENU order by MENU_ID";
    $cursor = exequery( $connection, $query );
    while ( $ROW = mysql_fetch_array( $cursor ) ){
        $MENU_NAME = str_replace( array( "\"", "\\", "'" ), array( "", "/", "" ), $ROW['MENU_NAME'] );
        $IMAGE = str_replace( array( "\"", "\\", "'" ), array( "", "/", "" ), $ROW['IMAGE'] );
        $MENU_EXT = unserialize( $ROW['MENU_EXT'] );
        reset( $LANG_ARRAY );
        foreach ( $LANG_ARRAY as $LANG => $VALUE ){
            if ( is_array( $MENU_EXT ) && $MENU_EXT[$LANG] != "" ){
                $MENU_NAME_SHOW = $MENU_EXT[$LANG];
            }else{
                $MENU_NAME_SHOW = $MENU_NAME;
            }
            $CACHE_ARRAY[$LANG]['cache2'] .= "   \"m".$ROW['MENU_ID']."\" => array(\"MENU_ID\" => \"".$ROW['MENU_ID']."\", \"FUNC_NAME\" => \"".$MENU_NAME_SHOW."\", \"IMAGE\" => \"".$ROW['IMAGE']."\"),\n";
            $CACHE_ARRAY[$LANG]['cache3'] .= "func_array[\"m".$ROW['MENU_ID']."\"]=[\"".$MENU_NAME_SHOW."\",\"".$IMAGE."\"];\n";
        }
        $query = "SELECT * from SYS_FUNCTION where MENU_ID like '".$ROW['MENU_ID']."%' order by MENU_ID";
        $cursor1 = exequery( $connection, $query );
        while ( $ROW = mysql_fetch_array( $cursor1 ) ){
            $FUNC_NAME = str_replace( array( "\"", "\\", "'" ), array( "", "/", "" ), $ROW['FUNC_NAME'] );
            $FUNC_CODE = str_replace( array( "\"", "\\", "'" ), array( "", "/", "" ), $ROW['FUNC_CODE'] );
            $FUNC_EXT = unserialize( $ROW['FUNC_EXT'] );
            $OPEN_WINDOW = substr( $FUNC_CODE, 0, 2 ) == "1:" ? 1 : 0;
            $FUNC_CODE = substr( $FUNC_CODE, 0, 2 ) == "1:" ? substr( $FUNC_CODE, 2 ) : $FUNC_CODE;
            if ( 10000 <= $ROW['FUNC_ID'] && $ROW['FUNC_ID'] <= 20000 ){
                $IMAGE = "fis";
            }else if ( stristr( $FUNC_CODE, "http://" ) ){
                $IMAGE = "menu_url";
            }else if ( stristr( $FUNC_CODE, "file://" ) ){
                $IMAGE = "winexe";
            }else if ( stristr( $FUNC_CODE, "/" ) ){
                $IMAGE = substr( $FUNC_CODE, 0, strpos( $FUNC_CODE, "/" ) );
            }else{
                $IMAGE = $FUNC_CODE;
            }
            reset( $LANG_ARRAY );
            foreach ( $LANG_ARRAY as $LANG => $VALUE ){
                if ( is_array( $FUNC_EXT ) && $FUNC_EXT[$LANG] != "" ){
                    $FUNC_NAME_SHOW = $FUNC_EXT[$LANG];
                }else{
                    $FUNC_NAME_SHOW = $FUNC_NAME;
                }
                $CACHE_ARRAY[$LANG]['cache1'] .= "   \"".$ROW['FUNC_ID']."\" => \"".$FUNC_CODE."\",\n";
                $CACHE_ARRAY[$LANG]['cache2'] .= "   \"".$ROW['FUNC_ID']."\" => array(\"FUNC_ID\" => \"".$ROW['FUNC_ID']."\", \"MENU_ID\" => \"".$ROW['MENU_ID']."\", \"FUNC_NAME\" => \"".$FUNC_NAME_SHOW."\", \"FUNC_CODE\" => \"".$FUNC_CODE."\", \"IMAGE\" => \"".$IMAGE."\"";
                $CACHE_ARRAY[$LANG]['cache3'] .= "func_array[\"f".$ROW['FUNC_ID']."\"]=[\"".$FUNC_NAME_SHOW."\",\"".$FUNC_CODE."\",\"".$IMAGE."\"";
                if ( $OPEN_WINDOW ){
                    $CACHE_ARRAY[$LANG]['cache2'] .= ", \"OPEN_WINDOW\" => ".$OPEN_WINDOW;
                    $CACHE_ARRAY[$LANG]['cache3'] .= ",\"".$OPEN_WINDOW."\"";
                }
                $CACHE_ARRAY[$LANG]['cache2'] .= "),\n";
                $CACHE_ARRAY[$LANG]['cache3'] .= "];\n";
            }
        }
    }
    $cache = new Cache();
    foreach ( $CACHE_ARRAY as $LANG => $VALUE ){
        $name1 = "SYS_FUNCTION_".bin2hex( $LANG );
        $name2 = "SYS_FUNCTION_ALL_".bin2hex( $LANG );
        $cache1 = "\$".$name1." = array(\n".substr( $CACHE_ARRAY[$LANG]['cache1'], 0, -2 )."\n);";
        $cache2 = "\$".$name2." = array(\n".substr( $CACHE_ARRAY[$LANG]['cache2'], 0, -2 )."\n);";
        eval( $cache1 );
        eval( $cache2 );
        $cache->set( $name1, $$name1, 0, 0 );
        $cache->set( $name2, $$name2, 0, 0 );
        $cache3 = "var func_array=[];\n".$CACHE_ARRAY[$LANG]['cache3'];
        $cache_file3 = $ROOT_PATH."include/sys_function_".bin2hex( $LANG ).".js";
        if(file_exists( $cache_file3 )===false){
            $fp= fopen($cache_file3,"w");
            fclose($fp);
        }
        if ( file_exists( $cache_file3 ) && is_writable( $cache_file3 ) ){
            file_put_contents( $cache_file3, $cache3 );
        }
    }
}

function add_sys_para($PARA_ARRAY) {
    global $connection;
    $PARA_VALUE = each(&$PARA_ARRAY)[1];
    $PARA_NAME = each(&$PARA_ARRAY)[0];
    while (each(&$PARA_ARRAY)) {
        $query = "SELECT * from SYS_PARA where PARA_NAME='" . $PARA_NAME . "'";
        $cursor = exequery($connection, $query);
        if (mysql_num_rows($cursor) <= 0) {
            $query = "insert into SYS_PARA (PARA_NAME, PARA_VALUE) values('" . $PARA_NAME . "', '{$PARA_VALUE}')";
            exequery($connection, $query);
        }
    }
}

function get_sys_para($PARA_NAME_STR) {
    global $connection;
    $PARA_ARRAY = array();
    $query = "SELECT * from SYS_PARA where find_in_set(PARA_NAME, '" . $PARA_NAME_STR . "')";
    $cursor = exequery($connection, $query);
    while ($ROW = mysql_fetch_array($cursor)) {
        $PARA_ARRAY[$ROW['PARA_NAME']] = $ROW['PARA_VALUE'];
    }
    return $PARA_ARRAY;
}

function set_sys_para($PARA_ARRAY) {
    global $connection;
    $PARA_VALUE = each($PARA_ARRAY)[1];
    $PARA_NAME = each($PARA_ARRAY)[0];
    while (each($PARA_ARRAY)) {
        $query = "update SYS_PARA set PARA_VALUE='" . $PARA_VALUE . "' where PARA_NAME='{$PARA_NAME}'";
        exequery($connection, $query);
    }
}

function add_sys_code($CODE_ARRAY) {
    global $connection;
    if (!is_array($CODE_ARRAY) || sizeof($CODE_ARRAY) < 1) {
        
    } else {
        foreach ($CODE_ARRAY as $FLAG => $SYS_CODE) {
            if ($SYS_CODE['PARENT_NO'] == "") {
                $query = "SELECT 1 from SYS_CODE where CODE_NO='" . $SYS_CODE['CODE_NO'] . "'";
                $cursor = exequery($connection, $query);
                if (0 < mysql_num_rows($cursor)) {
                    $FLAG = FALSE;
                }
            }
            if ($FLAG) {
                $query = "insert into SYS_CODE (`CODE_NO`, `CODE_NAME`, `CODE_ORDER`, `PARENT_NO`, `CODE_FLAG`, `CODE_EXT`) values('" . $SYS_CODE['CODE_NO'] . "', '" . $SYS_CODE['CODE_NAME'] . "', '" . $SYS_CODE['CODE_ORDER'] . "', '" . $SYS_CODE['PARENT_NO'] . "', '" . $SYS_CODE['CODE_FLAG'] . "', '" . mysql_escape_string($SYS_CODE['CODE_EXT']) . "')";
                exequery($connection, $query);
            }
        }
    }
}

/**
 * 生成组织机构树 select形式，可选中设置的值。
 * @param $DEPT_ID 未使用
 * @param $DEPT_CHOOSE 预先选中的值
 * @param $POST_OP 未使用
 * @param int $NO_CHILD_DEPT 未使用
 * @return string
 */
function dept_tree_all( $DEPT_ID, $DEPT_CHOOSE, $POST_OP, $NO_CHILD_DEPT = 0 )
{
    global $connection;

    $query = 'SELECT * FROM `department` WHERE `DEPT_PARENT`=0 ORDER BY `DEPT_NO` ASC';
    $cursor = exequery( $connection, $query );
    $OPTION_TEXT = '';
    $COUNT = 0;
    while ( $ROW = mysql_fetch_array( $cursor ) ) {
        ++ $COUNT;
        $ID = $ROW['DEPT_ID'];
        $DEPT_NAME = $ROW['DEPT_NAME'];
        $DEPT_NAME = htmlspecialchars( $DEPT_NAME );
        if ( $COUNT == mysql_num_rows( $cursor ) ) {
            $DEPT_LINE = '└';
        }
        else {
            $DEPT_LINE = '├';
        }
        $OPTION_TEXT .= '<option ';
        if ( $ID == $DEPT_CHOOSE ) {
            $OPTION_TEXT .= 'selected ';
        }
        $OPTION_TEXT .= 'value='.$ID.'>'.$DEPT_LINE.$DEPT_NAME.'</option>\n';

        $sub_query = 'SELECT * FROM `department` WHERE `DEPT_PARENT`='.$ID.' ORDER BY `DEPT_NO` ASC';
        $sub_cursor = exequery( $connection, $sub_query );
        $SUB_COUNT = 0;
        while ( $SUB_ROW = mysql_fetch_array( $sub_cursor ) ) {
            ++ $SUB_COUNT;
            $SUB_ID = $SUB_ROW['DEPT_ID'];
            $SUB_DEPT_NAME = $SUB_ROW['DEPT_NAME'];
            $SUB_DEPT_NAME = htmlspecialchars( $SUB_DEPT_NAME );
            if ( $COUNT == mysql_num_rows( $cursor ) && $SUB_COUNT == mysql_num_rows ($sub_cursor) ) {
                $SUB_DEPT_LINE = '&nbsp;└';
            }
            elseif ( $COUNT == mysql_num_rows( $cursor ) ) {
                $SUB_DEPT_LINE = '&nbsp;├';
            }
            elseif ( $SUB_COUNT == mysql_num_rows ($sub_cursor) ) {
                $SUB_DEPT_LINE = '│└';
            }
            else {
                $SUB_DEPT_LINE = '│├';
            }
            $OPTION_TEXT .= '<option ';
            if ( $SUB_ID == $DEPT_CHOOSE ) {
                $OPTION_TEXT .= 'selected ';
            }
            $OPTION_TEXT .= 'value='.$SUB_ID.'>'.$SUB_DEPT_LINE.$SUB_DEPT_NAME.'</option>\n';
        }
    }
    return $OPTION_TEXT;
}