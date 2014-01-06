<?php
require( "../../../include/auth.php" );
?>
<!DOCTYPE html>
<html>
<head>
    <title>修改菜单</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body class="bodycolor" topmargin="5">
<?php
$NAME_ARRAY = array( );
foreach ( $_POST as $KEY => $VALUE ){
    if ( substr( $KEY, 0, 10 ) == "MENU_NAME_" ){
        $BIN_CODE = substr( $KEY, 10 );
        $NAME_ARRAY[$BIN_CODE] = $VALUE;
    }
}
$MENU_NAME = $NAME_ARRAY[bin2hex( DEFAULT_LANG )];
if ( $MENU_NAME == "" ){
    message( _( "提示" ), _( "菜单名称不能为空！" ) );
    button_back_new( );
    exit( );
}
$MENU_EXT = array( );
$LANG_ARRAY = get_lang_array_new( );
foreach ( $LANG_ARRAY as $LANG => $LANG_DESC ){
    if ( $LANG == DEFAULT_LANG ){
        $BIN_CODE = bin2hex( $LANG );
        if ( $NAME_ARRAY[$BIN_CODE] != "" ){
            $MENU_EXT[$LANG] = $NAME_ARRAY[$BIN_CODE];
        }
    }
}
$MENU_EXT = 0 < count( $MENU_EXT ) ? mysql_escape_string( serialize( $MENU_EXT ) ) : "";
$query = "update SYS_MENU set MENU_NAME='".$MENU_NAME."', IMAGE='{$_POST['IMAGE']}', MENU_EXT='{$MENU_EXT}' where MENU_ID='{$_POST['MENU_ID']}'";
exequery( $connection, $query );
cacheMenu( );
message( "", _( "修改成功！" ) );
?>
<script>
    parent.menu_list.location.reload();
</script>
</body>
</html>