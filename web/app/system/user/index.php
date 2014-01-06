<?php
require( "../../../include/auth.php" );
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo _( "用户管理" );?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<?php
$query = "SELECT MAX(PRIV_NO) from USER_PRIV";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
    $PRIV_NO_MAX = $ROW['0'];
}
$query = "SELECT USER_PRIV from USER_PRIV where PRIV_NO='".$PRIV_NO_MAX."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
    $USER_PRIV_MAX = $ROW['0'];
}
if ( $USER_PRIV_MAX == $LOGIN_USER_PRIV && $LOGIN_USER_PRIV != 1 )
{
    echo "     <body class=\"bodycolor\" topmargin=\"5\">\r\n";
    message( _( "提示" ), _( "您的角色权限为最低，无法进行用户管理" ) );
    exit( );
}
?>
<frameset rows="40,*"  cols="*" frameborder="no" border="0" framespacing="0" id="frame1">
    <frame name="user_title" scrolling="no" noresize src="title.php" frameborder="NO">
    <frameset rows="*"  cols="200,*" frameborder="no" border="0" framespacing="0" id="frame2">
        <frame name="user_list" scrolling="auto" noresize src="user_list.php" frameborder="NO">
        <frame name="user_main" scrolling="auto" src="query.php" frameborder="NO">
    </frameset>
</frameset>
</html>

