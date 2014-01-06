<?php
require( "../../../include/auth.php" );
$USER_PRIV = $_GET['USER_PRIV'];
if ( $USER_PRIV != "" ){
    $TITLE = _( "编辑角色" );
}else{
    $TITLE = _( "新建角色" );
}
if ( $USER_PRIV != "" ){
    $query = "SELECT * from USER_PRIV where USER_PRIV='".$USER_PRIV."'";
    $cursor = exequery( $connection, $query );
    if ( $ROW = mysql_fetch_array( $cursor ) ){
        $PRIV_NO = $ROW['PRIV_NO'];
        $PRIV_NAME = $ROW['PRIV_NAME'];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo _( "角色编辑" );?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script Language="JavaScript">
        function CheckForm(){
            if(document.form1.USER_PRIV.value=="1"){
                if(!window.confirm("<?php echo _( "本角色为内置的'超级系统管理员'角色，确定要改其名称吗？" );?>"))
                    return (false);
            }
            if(document.form1.PRIV_NO.value==""){
                alert("<?php echo _( "角色序号不能为空！" );?>");
                return (false);
            }
            if(document.form1.PRIV_NAME.value=="") {
                alert("<?php echo _( "角色称谓不能为空！" );?>");
                return (false);
            }
        }
    </script>
</head>
<body class="bodycolor" topmargin="5" onload="document.form1.PRIV_NO.focus();">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
    <tr>
        <td class="Big"><img src="<?php echo SITE_URL;?>assets/images/edit.gif" WIDTH="22" HEIGHT="20" align="absmiddle">
            <span class="big3"><?php echo $TITLE;?></span>
        </td>
    </tr>
</table>
<?php message( _( "提示" ), _( "请合理设置角色序号，它决定了用户的排列位置，也代表了一种管理层次，序号越小，管理层次越高" ) );?>
<form action="<?php if ( $USER_PRIV != "" ){ echo "update";}else{ echo "insert";}?>.php" method="post" name="form1" onsubmit="return CheckForm();">
<table class="TableBlock" width="450" align="center">
    <tr>
        <td nowrap class="TableData"><?php echo _( "角色排序号：" );?></td>
        <td nowrap class="TableData">
            <input type="text" name="PRIV_NO" class="BigInput" size="5" maxlength="10" value="<?php echo $PRIV_NO;?>">&nbsp;<br>
        </td>
    </tr>
    <tr>
        <td nowrap class="TableData"><?php echo _( "角色名称：" );?></td>
        <td nowrap class="TableData">
            <input type="text" name="PRIV_NAME" class="BigInput" size="25" maxlength="100" value="<?php echo $PRIV_NAME;?>">&nbsp;
        </td>
    </tr>
    <tr>
        <td nowrap class="TableControl" colspan="2" align="center">
            <input type="hidden" value="<?php echo $USER_PRIV;?>" name="USER_PRIV">
            <input type="submit" value="<?php echo _( "确定" );?>" class="MyButton BigButton">&nbsp;&nbsp;
            <?php if ( $USER_PRIV != "" ){?>
                <input type="button" value="<?php echo _( "返回" );?>" class="MyButton BigButton" onclick="location='manage.php'">
            <?php }?>
        </td>
    </tr>
</table>
</form>
<?php if ( $USER_PRIV == 1 ){
    message( _( "提示" ), _( "本角色为内置的‘超级系统管理员’角色，具有特殊的职能，为admin用户的默认角色，可以编辑其名称，但应保留其‘超级系统管理员’内涵" ) );
}?>
</body>
</html>