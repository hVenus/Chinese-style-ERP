<?php
include_once( "inc/auth.php" );
ob_end_clean( );
$query = "update USER set KEY_SN='".$KEY_SN."' where USER_ID='{$LOGIN_USER_ID}'";
exequery( $connection, $query );
$query = "SELECT PASSWORD from USER where USER_ID='".$LOGIN_USER_ID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
				$PASSWORD = md5( $ROW['PASSWORD'] );
}
echo $LOGIN_USER_ID.",".$PASSWORD;
?>
