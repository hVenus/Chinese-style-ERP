<?php
require( "../../../include/auth.php" );
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo _( "角色管理" );?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<frameset rows="30,*"  cols="*" frameborder="NO" border="0" framespacing="0" id="frame1">
    <frame name="menu_top" scrolling="no" noresize src="menu_top.php" frameborder="0">
    <frame name="menu_main" scrolling="auto" noresize src="manage.php" frameborder="0">
</frameset>