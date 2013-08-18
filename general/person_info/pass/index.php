<?php
include_once( "inc/auth.php" );
include_once( "inc/utility_all.php" );
$query = "SELECT * from USER where USER_ID='".$LOGIN_USER_ID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
    $USER_NAME = $ROW['USER_NAME'];
    $LAST_PASS_TIME = $ROW['LAST_PASS_TIME'];
    if ( $LAST_PASS_TIME == "0000-00-00 00:00:00" )
    {
        $LAST_PASS_TIME = "";
    }
}
$query = "SELECT * from SYS_PARA where PARA_NAME='SEC_PASS_FLAG' or PARA_NAME='SEC_PASS_TIME' or PARA_NAME='SEC_PASS_MIN' or PARA_NAME='SEC_PASS_MAX' or PARA_NAME='SEC_PASS_SAFE'";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
    $PARA_NAME = $ROW['PARA_NAME'];
    $PARA_VALUE = $ROW['PARA_VALUE'];
    if ( $PARA_NAME == "SEC_PASS_FLAG" )
    {
        $SEC_PASS_FLAG = $PARA_VALUE;
    }
    else if ( $PARA_NAME == "SEC_PASS_TIME" )
    {
        $SEC_PASS_TIME = $PARA_VALUE;
    }
    else if ( $PARA_NAME == "SEC_PASS_MIN" )
    {
        $SEC_PASS_MIN = $PARA_VALUE;
    }
    else if ( $PARA_NAME == "SEC_PASS_MAX" )
    {
        $SEC_PASS_MAX = $PARA_VALUE;
    }
    else if ( $PARA_NAME == "SEC_PASS_SAFE" )
    {
        $SEC_PASS_SAFE = $PARA_VALUE;
    }
}
?>
<html>
<head>
    <title><?php echo _("修改密码");?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="/theme/<?php echo $LOGIN_THEME;?>/person_info.css">
</head>
<body class="bodycolor" onload="document.form1.PASS0.focus();">
<div class="PageHeader">
    <div class="title">
        <img src="/images/secure.gif" align="absmiddle">
        <?php echo _("修改密码");?>
    </div>
</div>
<form method="post" action="update.php" name="form1" >
<table class="TableBlock" width="500" align="center">
    <tr class="Big">
        <td class="TableData" width="120"><b><?php echo _("用户名"),_("：");?></b></td>
        <td class="TableData"><b><?php echo $LOGIN_USER_ID;?></b></td>
    </tr>
    <tr>
        <td class="TableData" ><?php echo _("原密码"),_("：");?></td>
        <td class="TableData" ><input type="password" name="PASS0"  class="BigInput" size="20"></td>
    </tr>
    <tr>
        <td class="TableData" ><?php echo _("新密码"),_("：");?></td>
        <td class="TableData" >
            <input type="password" name="PASS1"  class="BigInput" size="20" maxlength="<?php echo $SEC_PASS_MAX;?>" >
            <?php echo $SEC_PASS_MIN;?> - <?php echo $SEC_PASS_MAX;?> <?php echo _("位");?>
        <?php if ( $SEC_PASS_SAFE == "1" )    {?>
            <?php echo _("，必须同时包含字母和数字");?>
        <?php }?>
        </td>
    </tr>
    <tr>
        <td class="TableData" ><?php echo _("确认新密码"),_("：");?></td>
        <td class="TableData" >
            <input type="password" name="PASS2"  class="BigInput" size="20" maxlength="<?php echo $SEC_PASS_MAX;?>" >
            <?php echo $SEC_PASS_MIN;?> - <?php echo $SEC_PASS_MAX;?> <?php echo _("位");?>
        <?php if ( $SEC_PASS_SAFE == "1" )    {?>
            <?php echo _("，必须同时包含字母和数字");?>
        <?php }?>
        </td>
    </tr>
    <tr>
        <td class="TableData" ><?php echo _("上次修改时间"),_("：");?></td>
        <td class="TableData" ><?php echo $LAST_PASS_TIME;?></td>
    </tr>
<?php if ( $SEC_PASS_FLAG == "1" ){?>
<?php $REMARK = "您的密码将于 <span class=big4><b>".( $SEC_PASS_TIME - floor( ( time( ) - strtotime( $LAST_PASS_TIME ) ) / 24 / 3600 ) )."</span> </b>天后过期。";?>
<?php }else{?>
<?php $REMARK = _("密码永不过期");?>
<?php }?>
    <tr>
        <td class="TableData" ><?php echo _("密码过期"),_("：");?></td>
        <td class="TableData" ><?php echo $REMARK;?></td>
    </tr>
    <tr align="center" >
        <td class="TableControl" colspan="2" ><input type="submit" value="<?php echo _("保存修改");?>" class='BigButton'></td>
    </tr>
</table>
</form>
<table border="0" width="90%" cellspacing="0" cellpadding="3" class="small">
    <tr>
        <td class="Big">
            <img src="/images/green_arrow.gif" align="absmiddle">
            <span class="big3"><?php echo _("最近10次修改密码日志");?></span>
            <br>
        </td>
    </tr>
</table>
<?php
$TYPE_DESC = get_code_name( "14", "SYS_LOG" );
$query = "SELECT * from SYS_LOG where TYPE='14' and USER_ID='".$LOGIN_USER_ID."' and REMARK='' order by TIME desc";
$cursor = exequery( $connection, $query );
if ( mysql_num_rows( $cursor ) == 0 ){
    message( "", "无修改密码日志记录" );
    exit( );
}
?>
<table class="TableList" width="70%" align="center">
    <tr class="TableHeader">
        <td align="center"><?php echo _("用户");?></td>
        <td align="center"><?php echo _("时间");?></td>
        <td align="center"><?php echo _("IP地址");?></td>
        <td align="center"><?php echo _("类型");?></td>
        <td align="center"><?php echo _("备注");?></td>
    </tr>
<?php
$LOG_COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) ){
    ++$LOG_COUNT;
    if ( 10 < $LOG_COUNT ){
        break;
    }else{
    $TIME = $ROW['TIME'];
    $IP = $ROW['IP'];
    $TYPE = $ROW['TYPE'];
    $REMARK = $ROW['REMARK'];
}
if ( $LOG_COUNT % 2 == 1 ){
    $TableLine = "TableLine1";
}else{
    $TableLine = "TableLine2";
}
?>
    <tr class="<?php echo $TableLine;?>">
        <td nowrap align="center"><?php echo $USER_NAME;?></td>
        <td nowrap align="center"><?php echo $TIME;?></td>
        <td nowrap align="center"><?php echo $IP;?></td>
        <td nowrap align="center"><?php echo $TYPE_DESC;?></td>
        <td align="left"><?php echo $REMARK;?></td>
    </tr>
<?php }?>
</table>
</body>
</html>