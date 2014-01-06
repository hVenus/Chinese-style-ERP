<?php
require( "../../../include/auth.php" );
?>
<html>
<head>
    <title><?php echo _( "删除角色" );?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body class="bodycolor" topmargin="5">
<?php 
$USER_PRIV = $_GET['USER_PRIV'];
$query = "select * from USER where USER_PRIV='".$USER_PRIV."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) ){
    message( _( "提示" ), _( "该角色下存在用户，不能删除！" ) );
    button_back_new( );
    exit( );
}
$query = "delete from USER_PRIV where USER_PRIV='".$USER_PRIV."'";
exequery( $connection, $query );
header( "location: manage.php" );
?>
</body>
</html>