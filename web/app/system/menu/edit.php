<?php
require( "../../../include/auth.php" );
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo _("菜单编辑") ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script Language="JavaScript">
        function CheckForm(){
            for(var i=0; i< document.form1.length; i++)   {
                if(document.form1[i].name.substr(0, 10) == "MENU_NAME_" && document.form1[i].value==""){
                    alert("<?php echo _("菜单名称不能为空！") ?>");
                    return (false);
                }
            }
        }
    </script>
</head>
<?php
$query = "SELECT * from SYS_MENU where MENU_ID='".$_GET['MENU_ID']."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) ){
    $MENU_NAME = $ROW['MENU_NAME'];
    $IMAGE = $ROW['IMAGE'];
    $MENU_EXT = unserialize( $ROW['MENU_EXT'] );
    $LANGUAGE_TYPE = $ROW['LANGUAGE_TYPE'];
}

?>
<body class="bodycolor" topmargin="5">

<table width="100%" border=0 cellPadding=0 cellSpacing=0 borderColor=#ffffff bgColor=#dee7ff style="FONT-SIZE: 10pt">
    <tbody>
    <tr height=35>
        <td align=middle width=20 background="/images/title_left.gif"  bgColor="#dee7ff"></td>
        <td align=middle width=120 background="/images/title_left.gif" bgColor=#dee7ff><FONT color=#f7f7f7>编辑菜单主分类<font color="#FFFFFF">&nbsp;</font></FONT> </td>
        <td align=middle width=11 background="/images/title_middle.gif" bgColor=#dee7ff><FONT color=#f7f7f7>&nbsp;</FONT> </td>
        <td align=middle background="/images/title_right.gif" bgColor=#dee7ff><FONT color=#f7f7f7>&nbsp;</FONT> </td>
    </tr>
    </tbody>
</table>
<form action="update.php"  method="post" name="form1" onsubmit="return CheckForm();">
    <table class="TableBlock" width="450" align="center">
        <tr>
            <td nowrap class="TableData" width="120"><?php echo _("主菜单分类代码") ?>：</td>
            <td nowrap class="TableData">
                <input type="text" name="MENU_ID" class="BigStatic" size="20" maxlength="50" value="<?php echo $_GET['MENU_ID'];?>" readonly>&nbsp;</td>
        </tr>
        <?php
        $LANG_ARRAY = get_lang_array_new( );
        foreach ( $LANG_ARRAY as $LANG => $LANG_DESC ){
            $MENU_NAME_EXT = "";
            if ( $LANG == $MYOA_DEFAULT_LANG ){
                $MENU_NAME_EXT = $MENU_NAME;
            }else if ( is_array( $MENU_EXT ) && $MENU_EXT[$LANG] != "" ){
                $MENU_NAME_EXT = $MENU_EXT[$LANG];
            }
            ?>
            <tr>
                <td nowrap class="TableData"><?php echo _("菜单名称") ?>：(<?php echo $LANG_DESC;?>)</td>
                <td nowrap class="TableData"><input type="text" name="MENU_NAME_<?php echo bin2hex( $LANG );?>" class="BigInput" size="20" maxlength="50" value="<?php echo $MENU_NAME_EXT;?>">&nbsp;</td>
            </tr>
            <?php }?>
        <tr>
            <td nowrap class="TableData"><?php echo _("图片名") ?>：</td>
            <td nowrap class="TableData"><input type="text" name="IMAGE" class="BigInput" size="20" maxlength="50" value="<?php echo $IMAGE;?>">&nbsp;</td>
        </tr>
        <tr>
            <td nowrap  class="TableControl" colspan="2" align="center">
                <input type="submit" value="<?php echo _("确定") ?>" class="BigButton MyButton">&nbsp;&nbsp;
                <input type="button" value="<?php echo _("返回") ?>" class="BigButton MyButton" onclick="location='blank.php'">
            </td>
        </tr>
    </table>
</form>
</body>
</html>