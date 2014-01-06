<?php
require( "../../../../include/auth.php" );
$FUNC_ID1 = $_POST["FUNC_ID1"];
$MENU_PARENT = $_POST["MENU_PARENT"];
$MENU_ID = $_POST["MENU_ID"];
$FUNC_CODE1 = $_POST["FUNC_CODE1"];

$MENU_ID_NEW = $MENU_PARENT.$MENU_ID;
$query = "SELECT * from SYS_FUNCTION where FUNC_ID!='".$FUNC_ID1."' and MENU_ID='{$MENU_ID_NEW}'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) ){
    message( _( "提示" ), sprintf( _( "子菜单代码 %s 已存在！" ), $MENU_ID ) );
    button_back_new( );
    exit( );
}
$NAME_ARRAY = array( );
foreach ( $_POST as $KEY => $VALUE ){
    if ( substr( $KEY, 0, 10 ) == "FUNC_NAME_" )    {
        $BIN_CODE = substr( $KEY, 10 );
        $NAME_ARRAY[$BIN_CODE] = $VALUE;
    }
}
$FUNC_NAME = $NAME_ARRAY[bin2hex( DEFAULT_LANG )];
if ( $FUNC_NAME == "" ){
    message( _( "提示" ), _( "子菜单名称不能为空！" ) );
    button_back_new( );
    exit( );
}
$FUNC_EXT = array( );
$LANG_ARRAY = get_lang_array( );
foreach ( $LANG_ARRAY as $LANG => $LANG_DESC ){
    if ( $LANG == DEFAULT_LANG )    {
        $BIN_CODE = bin2hex( $LANG );
        if ( $NAME_ARRAY[$BIN_CODE] != "" )        {
            $FUNC_EXT[$LANG] = $NAME_ARRAY[$BIN_CODE];
        }
    }
}
$FUNC_EXT = 0 < count( $FUNC_EXT ) ? mysql_escape_string( serialize( $FUNC_EXT ) ) : "";
$query = "SELECT * from SYS_FUNCTION where FUNC_ID='".$FUNC_ID1."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) ){
    $MENU_ID_OLD = $ROW['MENU_ID'];
    $FUNC_CODE_OLD = $ROW['FUNC_CODE'];
}
if ( !( strlen( $MENU_ID_OLD ) == 4 ) || !( substr( $FUNC_CODE_OLD, 0, 1 ) == "@" ) ){
    $query = "SELECT * from SYS_FUNCTION where MENU_ID like '".$MENU_ID_OLD."%'";
    $cursor = exequery( $connection, $query );
    while ( $ROW = mysql_fetch_array( $cursor ) )    {
        $FUNC_ID_SUB = $ROW['FUNC_ID'];
        $MENU_ID_SUB = $ROW['MENU_ID'];
        $MENU_ID_SUB = $MENU_ID_NEW.substr( $MENU_ID_SUB, -2 );
        $query = "update SYS_FUNCTION set MENU_ID='".$MENU_ID_SUB."' where FUNC_ID='{$FUNC_ID_SUB}'";
        exequery( $connection, $query );
    }
}
$FUNC_CODE1 = $OPEN_WINDOW == "on" && substr( $FUNC_CODE1, 0, 1 ) != "@" ? "1:".$FUNC_CODE1 : $FUNC_CODE1;
$query = "update SYS_FUNCTION set MENU_ID='".$MENU_ID_NEW."',FUNC_NAME='{$FUNC_NAME}',FUNC_CODE='{$FUNC_CODE1}',FUNC_EXT='{$FUNC_EXT}',ACCESS_TYPE='{$ACCESS_TYPE}',LANGUAGE_TYPE='{$LANGUAGE_TYPE}' where FUNC_ID='{$FUNC_ID1}'";
exequery( $connection, $query );
$MENU_ID = substr( $MENU_ID_NEW, 0, 2 );
cacheMenu( );
header( "location:index.php?MENU_ID=".$MENU_ID );
?>
