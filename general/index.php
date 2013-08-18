<?php
include_once( "inc/auth.php" );
?>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script type="text/javascript" src="/inc/js/utility.js"></script>
    <script type="text/javascript">
        self.moveTo(0,0);
        self.resizeTo(screen.availWidth,screen.availHeight);
        self.focus();
        relogin=0;
        function exit()
        {
            if(document.body.clientWidth-event.clientX<50||event.altKey||event.ctrlKey) {
                var req = new_req();
                req.open("GET", "relogin.php", true);
                req.send('');
            }
        }
    </script>
</head>
<frameset rows="30,*,20"  cols="*" frameborder="no" border="0" framespacing="0" id="frame1" onbeforeunload="exit();">
    <frame name="logo_bar" id="logo_bar" scrolling="no" noresize="noresize" src="topbar.php?lc=<?php echo $i18n_COOKIE;?>" frameborder="0">
    <frameset rows="*"  cols="195,*" frameborder="no" border="0" framespacing="0" id="frame2">
        <frame name="leftmenu" id="leftmenu" scrolling="no" noresize="noresize" src="ipanel/?lc=<?php echo $i18n_COOKIE;?>" frameborder="0">
        <frame name="table_index" id="table_index" scrolling="no" src="table.php?lc=<?php echo $i18n_COOKIE;?>" frameborder="0">
    </frameset>
    <frame name="status_bar" id="status_bar" scrolling="no" noresize="noresize" src="status_bar/?lc=<?php echo $i18n_COOKIE;?>" frameborder="0">
</frameset>
<noframes></noframes>
</html>