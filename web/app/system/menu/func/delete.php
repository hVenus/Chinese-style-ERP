<?php
require( "../../../../include/auth.php" );
?>
<!DOCTYPE html>
<html>
<head>
    <title>删除菜单</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body class="bodycolor" topmargin="5">
<?php
$query = "delete from SYS_FUNCTION where FUNC_ID='".$_GET['FUNC_ID1']."'";
exequery( $connection, $query );
cacheMenu( );
$MENU_ID = substr( $_GET['MENU_ID'], 0, 2 );
header( "location:index.php?MENU_ID=".$MENU_ID );
?>
</body>
</html>