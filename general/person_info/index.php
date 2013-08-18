<?php
include_once( "inc/auth.php" );
include_once( "inc/utility_all.php" );
if ( $MAIN_URL == "" )
{
    $MAIN_URL = "mypriv";
}

?>
<html>
<head>
    <title><?php echo _("个人设置");?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="/theme/<?php  echo $LOGIN_THEME;?>/layout_left.css" />
    <link rel="stylesheet" type="text/css" href="/theme/<?php  echo $LOGIN_THEME;?>/person_info.css">
    <script type="text/javascript" src="/inc/js/jquery/jquery.min.js"></script>
</head>
<script>
    $(window).resize(function(){
        var height = $(c_main.document.body).attr('scrollHeight')+10;
        height = height > $(window).height() ? height : $(window).height();
        $('#c_main').height(height);}
    );
</script>
<body class="bodycolor">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td id="left">
            <div id="left_top" class="PageHeader person_info_icon"></div>
            <div id="menu">

                <div class="title"><?php echo _("帐号与安全");?></div>
                <div class="menu_container">
                    <a href="mypriv" target="c_main"><?php echo _("我的帐户");?></a>
                    <a href="pass" target="c_main"><?php echo _("修改密码");?></a>
                    <a href="log" target="c_main"><?php echo _("安全日志");?></a>
                </div>

                <div class="title"><?php echo _("帐户设置");?></div>
                <div class="menu_container">
                    <!--a href="diary" target="c_main"><?php echo _("工作日志");?></a-->
                    <!--a href="bind_email" target="c_main">Internet<?php echo _("邮箱绑定");?></a-->
                    <!--a href="myhr" target="c_main"><?php echo _("我的基本信息");?></a-->
                    <?php if($LOGIN_UID==1):?>
                    <!--a href="share" target="c_main"><?php echo _("信息共享设置");?></a-->
                    <!--a href="google_calendar" target="c_main"><?php echo _("Google日历同步设置");?></a-->
                    <?php endif;?>
                </div>
            </div>
        </td>
        <td id="right">
            <iframe id="c_main" name="c_main" src="<?php echo $MAIN_URL;?>" onload="$(window).triggerHandler('resize');" border="0" frameborder="0" framespacing="0" marginheight="0" marginwidth="0" style="width:100%;height:100%;"></iframe>
        </td>
    </tr>
</table>
</body>
</html>