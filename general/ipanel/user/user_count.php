<?php
include_once( "inc/auth.php" );
$CLIENT = intval( $CLIENT );
update_my_online_status( 0, $CLIENT );
$USER_COUNT = 0;
$query = "select count(*) from USER_ONLINE";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
    $USER_COUNT = $ROW[0];
}
ob_end_clean( );
echo $USER_COUNT == 0 ? 1 : $USER_COUNT;

