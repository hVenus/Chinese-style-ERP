<?php
require( "../../../../include/auth.php" );
?>
<!DOCTYPE html>
<html>
<head>
    <title>增加菜单</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body class="bodycolor" topmargin="5">
<?php
$query = "SELECT * from SYS_FUNCTION where FUNC_ID='".$_POST['FUNC_ID1']."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) ){
    message( _( "提示" ), sprintf( _( "子菜单项ID %s 已存在！" ), $_POST['FUNC_ID1'] ) );
    button_back_new( );
    exit( );
}
$MENU_ID_NEW = $_POST['MENU_PARENT'].$_POST['MENU_ID'];
$query = "SELECT * from SYS_FUNCTION where FUNC_ID!='".$_POST['FUNC_ID1']."' and MENU_ID='{$MENU_ID_NEW}'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) ){
    message( _( "提示" ), sprintf( _( "子菜单代码 %s 已存在！" ), $_POST['MENU_ID'] ) );
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
$FUNC_CODE1 = $OPEN_WINDOW == "on" && substr( $_POST['FUNC_CODE1'], 0, 1 ) != "@" ? "1:".$_POST['FUNC_CODE1'] : $_POST['FUNC_CODE1'];
$query = "insert into SYS_FUNCTION(FUNC_ID,MENU_ID,FUNC_NAME,FUNC_CODE,FUNC_EXT) VALUES (".$_POST['FUNC_ID1'].",'{$MENU_ID_NEW}','{$FUNC_NAME}','{$FUNC_CODE1}','{$FUNC_EXT}' )";
exequery( $connection, $query );
cacheMenu( );
$CREATE_BUTTON[] = array( "value" => _( "关闭" ), "href" => "javascript:window.close();" );
message( "", _( "增加成功！" ), "", $CREATE_BUTTON );
$MENU_ID = substr( $MENU_ID_NEW, 0, 2 );
?>
<script>
    if(parent && parent.menu_list){
        parent.menu_list.location.reload();
        location="index.php?MENU_ID=<?php echo $MENU_ID;?>";
    }
</script>
</body>
</html>