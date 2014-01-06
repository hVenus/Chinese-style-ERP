<?php
include_once( "../include/auth.php" );
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        a{color:#000;}
    </style>
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

<body topmargin="0" leftmargin="0" bgcolor="" style="margin:0px;padding:0px;background-repeat:no-repeat;background-image:url('<?php echo SITE_URL;?>assets/images/topbar.png');">
<div id="user_info"  style="font-size:9pt;padding-top:20px;padding-right:30px;text-align:right">
    <div style=" ">
        <?php echo $_SESSION["LOGIN_USER_NAME"];?>[<?php echo $_SESSION["LOGIN_USER_ID"];?>]</a>
        |
        <a href="javascript:re_login();"><?php echo _("注销");?></a>
    </div>
</div>
</body>
</html>