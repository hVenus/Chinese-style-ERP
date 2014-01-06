<?php
require( "../../../include/auth.php" );
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo _( "修改角色" );?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body class="bodycolor" topmargin="5">
<?php 
$PRIV_NO = $_POST['PRIV_NO'];
$PRIV_NAME = $_POST['PRIV_NAME'];
$USER_PRIV = $_POST['USER_PRIV'];

if ( !CheckType::is_number( $PRIV_NO ) )
{
    message( _( "错误" ), _( "角色序号应为数字！" ) );
    button_back_new( );
    exit( );
}
$query = "select PRIV_NO from USER_PRIV where USER_PRIV='".$USER_PRIV."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
    $PRIV_NO_OLD = $ROW['PRIV_NO'];
    if ( $PRIV_NO_OLD != $PRIV_NO )
    {
        set_sys_para( array( "ORG_UPDATE" => date( "Y-m-d H:i:s" ) ) );
    }
}
$query = "update USER_PRIV set PRIV_NO='".$PRIV_NO."',PRIV_NAME='".$PRIV_NAME."' where USER_PRIV='{$USER_PRIV}'";
exequery( $connection, $query );
header( "location: manage.php" );
?>
</body>
</html>