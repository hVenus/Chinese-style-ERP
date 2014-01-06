<?php
require( "../../../include/auth.php" );
//include_once( "inc/utility_all.php" );
//include_once( "inc/utility_org.php" );
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo _( "人员查询结果" );?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/inc/js_lang.php"></script>
    <script Language="JavaScript">
        function delete_user(DEPT_ID,USER_ID){
            var msg = sprintf("<?php echo _( "确认要删除用户 '%s' 吗？" );?>", USER_ID);
            if(window.confirm(msg)){
                URL="delete.php?DEPT_ID=" + DEPT_ID + "&USER_ID=" + USER_ID;
                window.location=URL;
            }
        }
        function no_pass(DEPT_ID,USER_ID){
            var msg = sprintf("<?php echo _( "确认要清空用户 '%s' 的密码吗？" );?>", USER_ID);
            if(window.confirm(msg)){
                URL="no_pass.php?DEPT_ID=" + DEPT_ID + "&USER_ID=" + USER_ID;
                window.location=URL;
            }
        }
    </script>
</head>
<body class="bodycolor" topmargin="5">
<?php
$LOGIN_USER_PRIV = $_SESSION['LOGIN_USER_PRIV'];
$LOGIN_USER_PRIV_OTHER = $_SESSION['LOGIN_USER_PRIV_OTHER'];
$USER_ID = $_POST['USER_ID'];
$USER_NAME = $_POST['USER_NAME'];
$BYNAME = $_POST['BYNAME'];
$SEX = $_POST['SEX'];
$DEPT_ID = $_POST['DEPT_ID'];
$query = "SELECT * from USER_PRIV where USER_PRIV=".$LOGIN_USER_PRIV;
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
    $PRIV_NO = $ROW['PRIV_NO'];
}
if ( $LOGIN_USER_PRIV_OTHER != "" )
{
    $query = "SELECT MIN(PRIV_NO) as PRIV_NO from USER_PRIV where find_in_set(USER_PRIV,'".$LOGIN_USER_PRIV_OTHER."')";
    $cursor = exequery( $connection, $query );
    if ( $ROW = mysql_fetch_array( $cursor ) )
    {
        $OTHER_MIN_PRIV_NO = $ROW['PRIV_NO'];
    }
}
if ( $USER_ID != "" )
{
    $WHERE_STR .= " and USER_ID like '%".$USER_ID."%'";
}
if ( $USER_NAME != "" )
{
    $WHERE_STR .= " and USER_NAME like '%".$USER_NAME."%'";
}
if ( $BYNAME != "" )
{
    $WHERE_STR .= " and BYNAME like '%".$BYNAME."%'";
}
if ( $SEX != "" )
{
    $WHERE_STR .= " and SEX=".$SEX;
}
if ( $DEPT_ID != "" )
{
    if ( $DEPT_ID != "0" )
    {
        $DEPT_ID_CHILD = td_trim( getchilddeptid( $DEPT_ID ) );
        $WHERE_STR .= " and USER.DEPT_ID in (".$DEPT_ID_CHILD.")";
    }
    else
    {
        $WHERE_STR .= " and USER.DEPT_ID=0";
    }
}
if ( $DEPT_ID != "0" )
{
    $WHERE_STR .= " and DEPARTMENT.DEPT_ID=USER.DEPT_ID";
}
if ( $DUTY_TYPE != "" )
{
    $WHERE_STR .= " and DUTY_TYPE=".$DUTY_TYPE;
}
if ( $USER_PRIV != "" )
{
    $WHERE_STR .= " and USER.USER_PRIV=".$USER_PRIV;
}
if ( $POST_PRIV != "" )
{
    $WHERE_STR .= " and POST_PRIV=".$POST_PRIV;
}
if ( $CANBROADCAST != "" )
{
    $WHERE_STR .= " and CANBROADCAST=".$CANBROADCAST;
}
if ( $NOT_LOGIN != "2" )
{
    $WHERE_STR .= " and NOT_LOGIN='".$NOT_LOGIN."'";
}
if ( $NOT_VIEW_USER != "2" )
{
    $WHERE_STR .= " and NOT_VIEW_USER='".$NOT_VIEW_USER."'";
}
if ( $NOT_VIEW_TABLE != "2" )
{
    $WHERE_STR .= " and NOT_VIEW_TABLE='".$NOT_VIEW_TABLE."'";
}
?>
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
    <tr>
        <td class="Big">
            <img src="<?php echo SITE_URL;?>assets/images/edit.gif" WIDTH="22" HEIGHT="20" align="absmiddle">
            <span class="big3"><?php echo _( "用户查询" );?></span>
            <span class="TextColor3" style="FONT-SIZE:9pt;"><?php echo _( "说明：密码为空用户显示为红色，禁止登录用户显示为灰色" );?></span>
        </td>
    </tr>
</table>
<?php
$USER_COUNT = 0;
$query = "SELECT * from USER,USER_PRIV";
if ( $DEPT_ID != "0" )
{
    $query .= ",DEPARTMENT";
}
if ( $LOGIN_USER_PRIV != "1" )
{
    if ( $OTHER_MIN_PRIV_NO == "" )
    {
        $query .= " where USER.USER_PRIV=USER_PRIV.USER_PRIV and USER_PRIV.PRIV_NO>".$PRIV_NO." and USER_PRIV.USER_PRIV!=1 ".$WHERE_STR." order by ";
    }
    else
    {
        $query .= " where USER.USER_PRIV=USER_PRIV.USER_PRIV and (USER_PRIV.PRIV_NO>".$PRIV_NO." OR USER_PRIV.PRIV_NO>{$OTHER_MIN_PRIV_NO})and USER_PRIV.USER_PRIV!=1 ".$WHERE_STR." order by ";
    }
}
else
{
    $query .= " where USER.USER_PRIV=USER_PRIV.USER_PRIV ".$WHERE_STR." order by ";
}
if ( $LAST_VISIT_TIME != "" )
{
    $query .= "LAST_VISIT_TIME ".$LAST_VISIT_TIME.",";
}
if ( $DEPT_ID != "0" )
{
    $query .= "DEPT_NO,";
}
$query .= "PRIV_NO,USER_NO,USER_NAME";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
    $USER_ID = $ROW['USER_ID'];
    $USER_NAME = $ROW['USER_NAME'];
    $BYNAME = $ROW['BYNAME'];
    $PASSWORD = $ROW['PASSWORD'];
    $DEPT_ID1 = $ROW['DEPT_ID'];
    $USER_PRIV = $ROW['USER_PRIV'];
    $POST_PRIV = $ROW['POST_PRIV'];
    $LAST_VISIT_TIME1 = $ROW['LAST_VISIT_TIME'];
    $NOT_LOGIN = $ROW['NOT_LOGIN'];
    $IDLE_TIME_DESC = "";
    if ( $LAST_VISIT_TIME1 == "0000-00-00 00:00:00" )
    {
        $LAST_VISIT_TIME1 = "";
    }
    else
    {
        $IDLE_TIME = time( ) - strtotime( $LAST_VISIT_TIME1 ) - $ONLINE_REF_SEC;
        if ( 0 < floor( $IDLE_TIME / 86400 ) )
        {
            $IDLE_TIME_DESC .= floor( $IDLE_TIME / 86400 )._( "天" );
        }
        if ( 0 < floor( $IDLE_TIME % 86400 / 3600 ) )
        {
            $IDLE_TIME_DESC .= floor( $IDLE_TIME % 86400 / 3600 )._( "小时" );
        }
        if ( 0 < floor( $IDLE_TIME % 3600 / 60 ) )
        {
            $IDLE_TIME_DESC .= floor( $IDLE_TIME % 3600 / 60 )._( "分" );
        }
        if ( $IDLE_TIME_DESC == "" )
        {
            $IDLE_TIME_DESC = _( "0分" );
        }
    }
    if ( !is_dept_priv( $DEPT_ID1 ) )
    {
    }
    else
    {
        ++$USER_COUNT;
        $query1 = "SELECT * from DEPARTMENT where DEPT_ID=".$DEPT_ID1;
        $cursor1 = exequery( $connection, $query1 );
        if ( $ROW = mysql_fetch_array( $cursor1 ) )
        {
            $DEPT_NAME = $ROW['DEPT_NAME'];
        }
        else
        {
            $DEPT_NAME = _( "离职人员/外部人员" );
        }
        if ( $POST_PRIV == "0" )
        {
            $POST_PRIV = _( "本部门" );
        }
        else if ( $POST_PRIV == "1" )
        {
            $POST_PRIV = _( "全体" );
        }
        else if ( $POST_PRIV == "2" )
        {
            $POST_PRIV = _( "指定部门" );
        }
        $query1 = "SELECT * from USER_PRIV where USER_PRIV='".$USER_PRIV."'";
        $cursor1 = exequery( $connection, $query1 );
        if ( $ROW = mysql_fetch_array( $cursor1 ) )
        {
            $USER_PRIV = $ROW['PRIV_NAME'];
        }
        $DEPT_LONG_NAME = dept_long_name( $DEPT_ID1 );
        if ( $USER_COUNT == 1 )
        {
            echo "<table border=\"0\" cellPadding=\"0\" cellSpacing=\"1\" bgcolor=\"#6386d6\" class=\"TableList\" width=\"100%\">\r\n";
        }
        $query = "SELECT count(*) from SYS_LOG where USER_ID='".$USER_ID."'";
        $cursor1 = exequery( $connection, $query );
        if ( $ROW1 = mysql_fetch_array( $cursor1 ) )
        {
            $LOGIN_COUNT = $ROW1[0];
        }
        if ( $USER_COUNT % 2 == 1 )
        {
            $TableLine = "TableLine1";
        }
        else
        {
            $TableLine = "TableLine2";
        }
        $TR_TITLE = "";
        $STYLE_STR = "";
        if ( $NOT_LOGIN )
        {
            $STYLE_STR = "COLOR:gray;";
            $TR_TITLE = $USER_NAME._( " 禁止登录OA" );
        }
        else if ( crypt( "", $PASSWORD ) == $PASSWORD )
        {
            $TR_TITLE = $USER_NAME._( " 登录密码为空" );
            $TableLine .= " TextColor2";
        }
        echo "    <tr bgcolor=\"#EFF3F7\" class=\"";
        echo $TableLine;
        echo "\" title=\"";
        echo $TR_TITLE;
        echo "\" style=\"";
        echo $STYLE_STR;
        echo "\">\r\n      <td nowrap align=\"center\" title=\"";
        echo $DEPT_LONG_NAME;
        echo "\"><u style=\"cursor:hand\">";
        echo $DEPT_NAME;
        echo "</u></td>\r\n      <td nowrap align=\"center\">";
        echo $USER_ID;
        echo "</td>\r\n      <td nowrap align=\"center\">";
        echo $USER_NAME;
        echo "</td>\r\n      <td nowrap align=\"center\">";
        echo $USER_PRIV;
        echo "</td>\r\n      <td nowrap align=\"center\">";
        echo $POST_PRIV;
        echo "</td>\r\n      <td align=\"center\">";
        echo $LAST_VISIT_TIME1;
        echo "</td>\r\n      <td align=\"center\">";
        echo $IDLE_TIME_DESC;
        echo "</td>\r\n      <td nowrap align=\"center\">";
        echo $LOGIN_COUNT;
        echo "</td>\r\n      <td nowrap align=\"center\">\r\n      <a href=\"user_edit.php?USER_ID=";
        echo $USER_ID;
        echo "\"> ";
        echo _( "编辑" );
        echo "</a>&nbsp;&nbsp;\r\n";
        if ( $USER_ID != "admin" && $USER_ID != $LOGIN_USER_ID )
        {
            echo "      <a href=\"javascript:delete_user('";
            echo $DEPT_ID1;
            echo "','";
            echo $USER_ID;
            echo "');\"> ";
            echo _( "删除" );
            echo "</a>\r\n";
        }
        if ( $LOGIN_USER_ID == "admin" )
        {
            echo "      <br><a href=\"javascript:no_pass('";
            echo $DEPT_ID1;
            echo "','";
            echo $USER_ID;
            echo "');\">";
            echo _( "admin清空密码" );
            echo "</a>\r\n";
        }
        echo "      </td>\r\n    </tr>\r\n";
    }
}
if ( $DEPT_ID == "" )
{
    $query = "SELECT * from USER,USER_PRIV";
    if ( $LOGIN_USER_PRIV != "1" )
    {
        if ( $OTHER_MIN_PRIV_NO == "" )
        {
            $query .= " where USER.USER_PRIV=USER_PRIV.USER_PRIV and USER_PRIV.PRIV_NO>".$PRIV_NO." and USER_PRIV.USER_PRIV!=1 ".$WHERE_STR." order by ";
        }
        else
        {
            $query .= " where USER.USER_PRIV=USER_PRIV.USER_PRIV and (USER_PRIV.PRIV_NO>".$PRIV_NO." OR USER_PRIV.PRIV_NO>{$OTHER_MIN_PRIV_NO}) and USER_PRIV.USER_PRIV!=1 ".$WHERE_STR." order by ";
        }
    }
    else
    {
        $query .= " where USER.USER_PRIV=USER_PRIV.USER_PRIV ".$WHERE_STR." order by ";
    }
    if ( $LAST_VISIT_TIME != "" )
    {
        $query .= "LAST_VISIT_TIME ".$LAST_VISIT_TIME.",";
    }
    $query .= "PRIV_NO,USER_NO,USER_NAME";
    $query = str_replace( "DEPARTMENT.DEPT_ID=USER.DEPT_ID", "USER.DEPT_ID=0", $query );
    $cursor = exequery( $connection, $query );
    while ( $ROW = mysql_fetch_array( $cursor ) )
    {
        $USER_ID = $ROW['USER_ID'];
        $USER_NAME = $ROW['USER_NAME'];
        $BYNAME = $ROW['BYNAME'];
        $PASSWORD = $ROW['PASSWORD'];
        $DEPT_ID1 = $ROW['DEPT_ID'];
        $USER_PRIV = $ROW['USER_PRIV'];
        $POST_PRIV = $ROW['POST_PRIV'];
        $LAST_VISIT_TIME1 = $ROW['LAST_VISIT_TIME'];
        $NOT_LOGIN = $ROW['NOT_LOGIN'];
        $IDLE_TIME_DESC = "";
        if ( $LAST_VISIT_TIME1 == "0000-00-00 00:00:00" )
        {
            $LAST_VISIT_TIME1 = "";
        }
        else
        {
            $IDLE_TIME = time( ) - strtotime( $LAST_VISIT_TIME1 ) - $ONLINE_REF_SEC;
            if ( 0 < floor( $IDLE_TIME / 86400 ) )
            {
                $IDLE_TIME_DESC .= floor( $IDLE_TIME / 86400 )._( "天" );
            }
            if ( 0 < floor( $IDLE_TIME % 86400 / 3600 ) )
            {
                $IDLE_TIME_DESC .= floor( $IDLE_TIME % 86400 / 3600 )._( "小时" );
            }
            if ( 0 < floor( $IDLE_TIME % 3600 / 60 ) )
            {
                $IDLE_TIME_DESC .= floor( $IDLE_TIME % 3600 / 60 )._( "分" );
            }
            if ( $IDLE_TIME_DESC == "" )
            {
                $IDLE_TIME_DESC = _( "0分" );
            }
        }
        if ( !is_dept_priv( $DEPT_ID1 ) )
        {
        }
        else
        {
            ++$USER_COUNT;
            $DEPT_NAME = _( "离职人员/外部人员" );
            if ( $POST_PRIV == "0" )
            {
                $POST_PRIV = _( "本部门" );
            }
            else if ( $POST_PRIV == "1" )
            {
                $POST_PRIV = _( "全体" );
            }
            else if ( $POST_PRIV == "2" )
            {
                $POST_PRIV = _( "指定部门" );
            }
            $query1 = "SELECT * from USER_PRIV where USER_PRIV='".$USER_PRIV."'";
            $cursor1 = exequery( $connection, $query1 );
            if ( $ROW = mysql_fetch_array( $cursor1 ) )
            {
                $USER_PRIV = $ROW['PRIV_NAME'];
            }
            $DEPT_LONG_NAME = dept_long_name( $DEPT_ID1 );
            if ( $USER_COUNT == 1 )
            {
                echo "<table border=\"0\" cellPadding=\"0\" cellSpacing=\"1\" bgcolor=\"#6386d6\" class=\"TableList\" width=\"100%\">\r\n";
            }
            $query = "SELECT count(*) from SYS_LOG where USER_ID='".$USER_ID."'";
            $cursor1 = exequery( $connection, $query );
            if ( $ROW1 = mysql_fetch_array( $cursor1 ) )
            {
                $LOGIN_COUNT = $ROW1[0];
            }
            if ( $USER_COUNT % 2 == 1 )
            {
                $TableLine = "TableLine1";
            }
            else
            {
                $TableLine = "TableLine2";
            }
            $TR_TITLE = "";
            $STYLE_STR = "";
            if ( $NOT_LOGIN )
            {
                $STYLE_STR = "COLOR:gray;";
                $TR_TITLE = $USER_NAME._( " 禁止登录OA" );
            }
            else if ( crypt( "", $PASSWORD ) == $PASSWORD )
            {
                $TR_TITLE = $USER_NAME._( " 登录密码为空" );
                $TableLine .= " TextColor2";
            }
            echo "    <tr bgcolor=\"#EFF3F7\" class=\"";
            echo $TableLine;
            echo "\" title=\"";
            echo $TR_TITLE;
            echo "\" style=\"";
            echo $STYLE_STR;
            echo "\">\r\n      <td nowrap align=\"center\" title=\"";
            echo $DEPT_LONG_NAME;
            echo "\"><u style=\"cursor:hand\">";
            echo $DEPT_NAME;
            echo "</u></td>\r\n      <td nowrap align=\"center\">";
            echo $USER_ID;
            echo "</td>\r\n      <td nowrap align=\"center\">";
            echo $USER_NAME;
            echo "</td>\r\n      <td nowrap align=\"center\">";
            echo $USER_PRIV;
            echo "</td>\r\n      <td nowrap align=\"center\">";
            echo $POST_PRIV;
            echo "</td>\r\n      <td align=\"center\">";
            echo $LAST_VISIT_TIME1;
            echo "</td>\r\n      <td align=\"center\">";
            echo $IDLE_TIME_DESC;
            echo "</td>\r\n      <td nowrap align=\"center\">";
            echo $LOGIN_COUNT;
            echo "</td>\r\n      <td nowrap align=\"center\">\r\n      <a href=\"user_edit.php?USER_ID=";
            echo $USER_ID;
            echo "\"> ";
            echo _( "编辑" );
            echo "</a>&nbsp;&nbsp;\r\n";
            if ( $USER_ID != "admin" && $USER_ID != $LOGIN_USER_ID )
            {
                echo "      <a href=\"javascript:delete_user('";
                echo $DEPT_ID1;
                echo "','";
                echo $USER_ID;
                echo "');\"> ";
                echo _( "删除" );
                echo "</a>\r\n";
            }
            if ( $LOGIN_USER_ID == "admin" )
            {
                echo "      <br><a href=\"javascript:no_pass('";
                echo $DEPT_ID1;
                echo "','";
                echo $USER_ID;
                echo "');\">";
                echo _( "admin清空密码" );
                echo "</a>\r\n";
            }
            echo "      </td>\r\n    </tr>\r\n";
        }
    }
}
if ( 0 < $USER_COUNT )
{
    ?>
    <thead class="TableHeader">
    <tr bgcolor="#EFF3F7">
        <td nowrap align="center"><?php echo _( "部门" );?></td>
        <td nowrap align="center"><?php echo _( "用户名" );?></td>
        <td nowrap align="center"><?php echo _( "姓名" );?></td>
        <td nowrap align="center"><?php echo _( "角色" );?></td>
        <td nowrap align="center"><?php echo _( "管理" );?></td>
        <td nowrap align="center"><?php echo _( "最后访问" );?></td>
        <td nowrap align="center"><?php echo _( "闲置" );?></td>
        <td nowrap align="center"><?php echo _( "登录" );?></td>
        <td nowrap align="center"><?php echo _( "操作" );?></td>
    </tr>
    </thead>
    </table>
    <?php
    message( "", sprintf( _( "共%d个符合条件且可管理的用户" ), $USER_COUNT ) );
}
else
{
    message( "", _( "无符合条件且可管理的用户" ) );
}
echo "\r\n<br>\r\n<div align=\"center\">\r\n <input type=\"button\"  value=\"";
echo _( "返回" );
echo "\" class=\"BigButton\" onClick=\"history.back();\">\r\n</div>\r\n\r\n";
?>
</body>
</html>