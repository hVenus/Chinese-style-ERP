<?php
include_once( "inc/auth.php" );
include_once( "inc/utility_all.php" );
include_once( "inc/ip2add.new.php" );
$query = "SELECT * from USER where USER_ID='".$LOGIN_USER_ID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
    $USER_NAME = $ROW['USER_NAME'];
}
?>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="/theme/<?php echo $LOGIN_THEME;?>/person_info.css">
</head>
<body class="bodycolor">
<div class="PageHeader">
    <div class="title"><img src="/images/secure.gif" align="absmiddle"><?php echo _("最近20条系统安全日志");?></div>
</div>
<?php
$query = "SELECT * from SYS_LOG where (TYPE='1' or TYPE='2' or TYPE='14') and USER_ID='".$LOGIN_USER_ID."' order by TIME desc";
$cursor = exequery( $connection, $query );
if ( mysql_num_rows( $cursor ) == 0 ){
    message( "", "无系统安全日志记录" );
    exit( );
}
?>
<table class="TableList" width="90%">
    <tr class="TableHeader">
        <td align="center"><?php echo _("用户");?></td>
        <td align="center"><?php echo _("时间");?></td>
        <td align="center"><?php echo _("IP地址");?></td>
        <td align="center"><?php echo _("IP所在地");?></td>
        <td align="center"><?php echo _("类型");?></td>
        <td align="center"><?php echo _("备注");?></td>
    </tr>
<?php
    $LOG_COUNT = 0;
while ( $ROW = mysql_fetch_array( $cursor ) ){
    ++$LOG_COUNT;
    if ( 20 < $LOG_COUNT ){
        break;
    }else{
$TIME = $ROW['TIME'];
$IP = $ROW['IP'];
$TYPE = $ROW['TYPE'];
$REMARK = $ROW['REMARK'];
$IP_ADD = ip2add( $IP );
$TYPE_DESC = get_code_name( $TYPE, "SYS_LOG" );
}
if ( $LOG_COUNT % 2 == 1 )
{
$TableLine = "TableLine1";
}
else
{
$TableLine = "TableLine2";
}
    ?>
    <tr class="<?php echo $TableLine;?>">
        <td nowrap align="center"><?php echo $USER_NAME;?></td>
        <td nowrap align="center"><?php echo $TIME;?></td>
        <td nowrap align="center"><?php echo $IP;?></td>
        <td nowrap align="center"><?php echo $IP_ADD;?></td>
        <td nowrap align="center"><?php echo $TYPE_DESC;?></td>
        <td align="left"><?php echo $REMARK;?></td>
    </tr>
<?php }?>
</table>
</body>
</html>