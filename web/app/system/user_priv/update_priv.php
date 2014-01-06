<?php
require( "../../../include/auth.php" );
$FUNC_ID_STR = $_POST['FUNC_ID_STR'];
$USER_PRIV = $_POST['USER_PRIV'];
$FUNC_ID_STR = str_replace( "undefined,", "", $FUNC_ID_STR );
$query = "update USER_PRIV set FUNC_ID_STR='".$FUNC_ID_STR."' where USER_PRIV='{$USER_PRIV}'";
exequery( $connection, $query );
if ( $_SESSION['LOGIN_USER_PRIV'] == $USER_PRIV ){
    $_SESSION['LOGIN_FUNC_STR'] = $FUNC_ID_STR;
}
header( "location: manage.php" );
?>