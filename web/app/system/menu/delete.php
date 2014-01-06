<?php
require( "../../../include/auth.php" );
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
$query = "delete from SYS_MENU where MENU_ID='".$_GET['MENU_ID']."'";
exequery( $connection, $query );
$query = "delete from SYS_FUNCTION where MENU_ID like '".$_GET['MENU_ID']."%'";
exequery( $connection, $query );
cacheMenu( );
message( "", _( "菜单已删除！" ) );
?>
<script>
    parent.menu_list.location.reload();
</script>
</body>
</html>