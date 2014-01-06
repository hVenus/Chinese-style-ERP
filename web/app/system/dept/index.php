<?php
require( "../../../include/auth.php" );
?>
<title>部门管理</title>
<frameset rows="40,*"  cols="*" frameborder="NO" border="0" framespacing="0" id="frame1">
    <frame name="dept_title" scrolling="no" noresize src="title.php" frameborder="NO">
    <frameset rows="*"  cols="200,*" frameborder="no" border="0" framespacing="0" id="frame2">
        <frame name="dept_list" scrolling="auto" noresize src="dept_list.php" frameborder="no">
        <frame name="dept_main" scrolling="auto" src="dept_new.php" frameborder="no">
    </frameset>
</frameset>
