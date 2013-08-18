<?php
include_once( "inc/auth.php" );
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script language="JavaScript">
        function re_login()
        {
            var msg=" \n\n<?php echo _("确定要退出吗");?>";
            if(window.confirm(msg))
            {
                parent.parent.relogin=1;
                parent.parent.location="relogin.php";
            }
        }
    </script>
    <script>

    </script>
</head>

<body topmargin="0" leftmargin="0" STYLE="margin:0pt;padding:0pt">
<div style="float:left;"></div>
<div id="user_info" style="float: right;">
    <div style="float:right; margin-top: 5px; ">
        <a href="../general/person_info/" target="main"><?php echo $LOGIN_USER_NAME;?></a>
        |
        <a href="../general/mytable/intel_view" target="main">
            <img src="/images/menu/mytable.gif" align="absmiddle" width="20" height="20" border="0" alt="<?php echo _( "我的办公桌" );?>">
            <?php echo _( "桌面" );?>
        </a>
        |
        <a href="javascript:re_login();"><?php echo _("退出");?></a>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </div>
</div>
</body>
</html>
