<?php
include_once( "inc/auth.php" );

$query = "SELECT * from USER where USER_ID='".$LOGIN_USER_ID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
    $USER_NAME = $ROW['USER_NAME'];
    $SEX = $ROW['SEX'];
    $DEPT_ID = $ROW['DEPT_ID'];
    $USER_PRIV = $ROW['USER_PRIV'];
    $POST_PRIV = $ROW['POST_PRIV'];
    $POST_DEPT = $ROW['POST_DEPT'];
    $DUTY_TYPE = $ROW['DUTY_TYPE'];
    $USER_PRIV_OTHER = $ROW['USER_PRIV_OTHER'];
    $USER_NO = $ROW['USER_NO'];
    $NOT_VIEW_USER = $ROW['NOT_VIEW_USER'];
    $NOT_VIEW_TABLE = $ROW['NOT_VIEW_TABLE'];
    $NOT_SEARCH = $ROW['NOT_SEARCH'];
    $BYNAME = $ROW['BYNAME'];
    $BIRTHDAY = $ROW['BIRTHDAY'];
    $THEME = $ROW['THEME'];
    $MOBIL_NO = $ROW['MOBIL_NO'];
    $MOBIL_NO_HIDDEN = $ROW['MOBIL_NO_HIDDEN'];
    $BIND_IP = $ROW['BIND_IP'];
    $USEING_KEY = $ROW['USEING_KEY'];
    $CANBROADCAST = $ROW['CANBROADCAST'];
    $EMAIL_CAPACITY = $ROW['EMAIL_CAPACITY'];
    $FOLDER_CAPACITY = $ROW['FOLDER_CAPACITY'];
    if ( $EMAIL_CAPACITY == 0 )
    {
        $EMAIL_CAPACITY = _( "不限制" );
    }
    if ( $FOLDER_CAPACITY == 0 )
    {
        $FOLDER_CAPACITY = _( "不限制" );
    }
    $BIRTHDAY = strtok( $BIRTHDAY, " " );
    if ( $BIRTHDAY == "0000-00-00" )
    {
        $BIRTHDAY = "";
    }
}
$query1 = "SELECT * from USER_PRIV where USER_PRIV='".$USER_PRIV."'";
$cursor1 = exequery( $connection, $query1 );
if ( $ROW = mysql_fetch_array( $cursor1 ) )
{
    $PRIV_NAME = $ROW['PRIV_NAME'];
}
$TOK = strtok( $USER_PRIV_OTHER, "," );
while ( $TOK != "" )
{
    $query1 = "SELECT * from USER_PRIV where USER_PRIV='".$TOK."'";
    $cursor1 = exequery( $connection, $query1 );
    if ( $ROW = mysql_fetch_array( $cursor1 ) )
    {
        $OTHER_PRIV_NAME .= $ROW['PRIV_NAME'].",";
    }
    $TOK = strtok( "," );
}
if ( substr( $OTHER_PRIV_NAME, -1 ) == "," )
{
    $OTHER_PRIV_NAME = substr( $OTHER_PRIV_NAME, 0, -1 );
}
if ( $POST_PRIV == "1" )
{
    $POST_PRIV = _( "全体" );
}
else if ( $POST_PRIV == "2" )
{
    $POST_PRIV = _( "指定部门" );
}
else if ( $POST_PRIV == "0" )
{
    $POST_PRIV = _( "本部门" );
}
if ( $POST_PRIV == _( "指定部门" ) )
{
    $TOK = strtok( $POST_DEPT, "," );
    while ( $TOK != "" )
    {
        $query1 = "SELECT * from DEPARTMENT where DEPT_ID='".$TOK."'";
        $cursor1 = exequery( $connection, $query1 );
        if ( $ROW = mysql_fetch_array( $cursor1 ) )
        {
            $POST_DEPT_NAME .= $ROW['DEPT_NAME'].",";
        }
        $TOK = strtok( "," );
    }
    if ( substr( $POST_DEPT_NAME, -1 ) == "," )
    {
        $POST_DEPT_NAME = substr( $POST_DEPT_NAME, 0, -1 );
    }
}
?>
<html>
<head>
    <title><?php echo _("我的帐户");?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="/theme/9/person_info.css">
</head>
<body class="bodycolor" topmargin="5">
<div class="PageHeader">
    <div class="title">
        <img src="/images/secure.gif" align="absmiddle"> <?php echo _("我的帐户");?>(<?php echo $USER_NAME;?>)
    </div>
</div>
<br>
<table class="TableTop" width="90%">
    <tr>
        <td class="left"></td>
        <td class="center"><?php echo _("用户角色与管理范围");?></td>
        <td class="right"></td>
    </tr>
</table>
<table class="TableBlock no-top-border" width="90%">
    <tr class="TableData" height="25">
        <td nowrap width="15%"><?php echo _("主角色"),_("：");?></td>
        <td width=500><?php echo $PRIV_NAME;?></td>
    </tr>
    <tr class="TableData" height="25">
        <td nowrap><?php echo _("辅助角色"),_("：");?></td>
        <td><?php echo $OTHER_PRIV_NAME;?></td>
    </tr>
    <tr class="TableData" height="25">
        <td nowrap><?php echo _("管理范围"),_("：");?></td>
        <td><?php echo $POST_PRIV;?><?php if ( $POST_DEPT_NAME != "" ){echo "<br><br>".$POST_DEPT_NAME;}?></td>
    </tr>
    <tr>
        <td nowrap class="TableHeader" colspan="2"><b>&nbsp;<?php echo _("系统使用权限");?></b></td>
    </tr>
    <tr class="TableData">
        <td nowrap width="15%"><?php echo _("访问限制"),_("：");?></td>
        <td nowrap >
            <input type="checkbox" disabled name="NOT_VIEW_USER"  <?php if ( $NOT_VIEW_USER ) {   echo "checked";    }    ?>>
            <?php echo _("禁止查看用户列表");?>
            &nbsp;
            <input type="checkbox" disabled name="NOT_VIEW_TABLE"    <?php if ( $NOT_VIEW_TABLE )    {    echo "checked";    }?>>
            <?php echo _("禁止显示桌面");?>
            &nbsp;
        </td>
    </tr>
</table>
</body>
</html>