<?php
include_once( "inc/auth.php" );
include_once( "inc/utility_all.php" );
$query = "delete from USER_ONLINE where UID='".$LOGIN_UID."'";
exequery( $connection, $query );
add_log( 22, "", $LOGIN_USER_ID );
clear_online_status( );
session_start( );
session_destroy( );
?>
<html>
<head>
    <title><?php echo _("正在注销系统...");?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script>location="../"</script>
</head>
</html>