<?php
require( "../../../include/auth.php" );
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body class="bodycolor" topmargin="5">
<?php
$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
$LOGIN_DEPT_ID = $_SESSION['LOGIN_DEPT_ID'];
$query = "SELECT POST_PRIV,POST_DEPT from USER where USER_ID='".$LOGIN_USER_ID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
    $POST_PRIV = $ROW['POST_PRIV'];
    $POST_DEPT = $ROW['POST_DEPT'];
}
if ( $POST_PRIV == "1" )
{
    $DEPT_PRIV = _( "全体" );
}else if ( $POST_PRIV == "2" ){
    $DEPT_PRIV = _( "指定部门" );
}else{
    $query1 = "select DEPT_NAME from DEPARTMENT where DEPT_ID=".$LOGIN_DEPT_ID;
    $cursor1 = exequery( $connection, $query1 );
    if ( $ROW = mysql_fetch_array( $cursor1 ) )
    {
        $DEPT_PRIV = $ROW['DEPT_NAME'];
    }
}
?>


<TABLE width="100%" border=0 cellPadding=0 cellSpacing=0 borderColor=#ffffff bgColor=#dee7ff style="FONT-SIZE: 10pt">
    <TBODY>
    <TR height=35>
        <TD align=middle width=20 background="<?php echo SITE_URL;?>assets/images/title_left.gif"  bgColor="#dee7ff"></TD>
        <TD align=middle width=100 background="<?php echo SITE_URL;?>assets/images/title_left.gif" bgColor=#dee7ff>
            <FONT color=#f7f7f7><?php echo sprintf( _( "用户管理" ), $DEPT_PRIV ); ?><font color="#FFFFFF">&nbsp;</font></FONT>
        </TD>
        <TD align=middle width=11 background="<?php echo SITE_URL;?>assets/images/title_middle.gif" bgColor=#dee7ff><FONT color=#f7f7f7>&nbsp;</FONT> </TD>
        <TD align=middle background="<?php echo SITE_URL;?>assets/images/title_right.gif" bgColor=#dee7ff><FONT color=#f7f7f7>&nbsp;</FONT> </TD>
    </TR>
    </TBODY>
</TABLE>

</body>
</html>