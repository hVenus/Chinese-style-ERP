<?php
require( "../../../../include/auth.php" );
require( "../../../../include/sys_function_all.php" );
if ( isset( $MENU_ID_NEW ) ){
    $MENU_ID = $MENU_ID_NEW;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>菜单新建</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script Language="JavaScript">
        function CheckForm(){
            if(document.form1.FUNC_ID1.value==""){
                alert("子菜单项ID不能为空！");
                return (false);
            }
            if(document.form1.MENU_ID.value==""){
                alert("子菜单代码不能为空！");
                return (false);
            }
            if(document.form1.MENU_ID.value.length!=2){
                alert("子菜单代码应为2位！");
                return (false);
            }
            for(var i=0; i< document.form1.length; i++){
                if(document.form1[i].name.substr(0, 10) == "FUNC_NAME_" && document.form1[i].value==""){
                    alert("子菜单名称不能为空！");
                    return (false);
                }
            }
        }
    </script>
</head>
<?php
$query = "SELECT max(FUNC_ID) from SYS_FUNCTION where FUNC_ID<1000";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) ){
    $FUNC_ID_MAX1 = $ROW[0];
}
$query = "SELECT max(func_id) from SYS_FUNCTION where FUNC_ID>1000 and FUNC_ID<10000";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) ){
    $FUNC_ID_MAX2 = $ROW[0];
}
if ( $FUNC_ID_MAX2 == 0 ){
    $FUNC_ID_MAX2 = 1000;
}
?>
<body class="bodycolor" topmargin="5" onLoad="document.form1.MENU_ID.focus();">

<table width="100%" border="0" cellPadding="0" cellSpacing="0" borderColor="#ffffff" bgColor="#dee7ff" >
    <tbody>
    <tr height=35>
        <td align=middle width=20 background="/images/title_left.gif"  bgColor="#dee7ff"></td>
        <td align=middle width=120 background="/images/title_left.gif" bgColor=#dee7ff><FONT color=#f7f7f7>新建子菜单项<font color="#FFFFFF">&nbsp;</font></FONT> </td>
        <td align=middle width=11 background="/images/title_middle.gif" bgColor=#dee7ff><FONT color=#f7f7f7>&nbsp;</FONT> </td>
        <td align=middle background="/images/title_right.gif" bgColor=#dee7ff><FONT color=#f7f7f7>&nbsp;</FONT> </td>
    </tr>
    </tbody>
</table>
<?php message( "", _( "目前的子菜单项ID使用情况如下：<br>1000以内最大为".$FUNC_ID_MAX1."<br>1000以上,10000以下最大为{$FUNC_ID_MAX2}" ) );?>
<form action="insert.php"  method="post" name="form1" onSubmit="return CheckForm();">
    <table class="TableBlock" width="90%" align="center">
        <tr>
            <td nowrap class="TableData" width="120">子菜单项ID：</td>
            <td nowrap class="TableData">
                <input type="text" name="FUNC_ID1" class="BigInput" size="20" maxlength="50" value="<?php echo $FUNC_ID_MAX2 + 1;?>">
                <br>
                说明：用户添加的菜单项ID务必大于1000，小于10000；1000以内及10000以上为系统保留
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData" width="120">上级菜单：</td>
            <td nowrap class="TableData">
                <select name="MENU_PARENT" class="BigSelect">
                    <?php
                    foreach($SYS_FUNCTION as $MENU_ITEM){
                        $ITEM_ID = $MENU_ITEM['MENU_ID'];
                        $ITEM_NAME = $MENU_ITEM['FUNC_NAME'];
                        $ITEM_CODE = $MENU_ITEM['FUNC_CODE'];
                        if(strlen( $ITEM_ID ) == 2){
                            ?>
                            <option value="<?php echo $ITEM_ID;?>" <?php if ( $_GET['MENU_ID'] == $ITEM_ID ){ echo " selected"; }?> ><?php  echo $ITEM_NAME;?></option>
                            <?php
                            $child = Menu::getChildMenu($SYS_FUNCTION, $ITEM_ID);
                            foreach($child as $child_item){
                                $child_item_id = $child_item['MENU_ID'];
                                $child_item_name = $child_item['FUNC_NAME'];
                                $child_item_code = $child_item['FUNC_CODE'];
                                if(substr($child_item_code, 0, 1)=='@'){
                                    ?>
                                    <option value="<?php echo $child_item_id;?>"  >&nbsp;&nbsp;├<?php  echo $child_item_name;?></option>
                                    <?php
                                }
                            }
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData" width="120">子菜单项代码：</td>
            <td nowrap class="TableData">
                <input type="text" name="MENU_ID" class="BigInput" size="20" maxlength="2" value="">
                <br>
                说明：此代码为两位，作为排序之用。在同一父菜单下的平级菜单，该代码不能重复
            </td>
        </tr>
        <?php
        $LANG_ARRAY = get_lang_array_new( );
        foreach ( $LANG_ARRAY as $LANG => $LANG_DESC ){
            ?>
            <tr>
                <td nowrap class="TableData">子菜单名称：(<?php echo $LANG_DESC;?>)</td>
                <td nowrap class="TableData">
                    <input type="text" name="FUNC_NAME_<?php echo bin2hex( $LANG );?>" class="BigInput" size="20" maxlength="50" value="<?php echo $FUNC_NAME_NEW;?>">&nbsp;
                </td>
            </tr>
            <?php
        }
        ?>
        <tr>
            <td nowrap class="TableData">子菜单模块路径：</td>
            <td class="TableData">
                <input type="text" name="FUNC_CODE1" class="BigInput" size="40" value="<?php echo $FUNC_CODE_NEW;?>">
                <input type="checkbox" name="OPEN_WINDOW" id="OPEN_WINDOW">
                <label for="OPEN_WINDOW">在新窗口打开该菜单</label>
            </td>
        </tr>
        <tr>
            <td class="TableData" colspan=2>
                <b>说明：子菜单模块路径定义方式，应根据此菜单项的类型决定:</b>
                <br><br>
                <b>类型一，此菜单下仍存在下级菜单：</b>
                则填写@英文名称，格式如：@mail，对应的图片是：OA安装目录/webroot/images/menu/@mail.gif，注意：请一定要以@开头
                <br><br>
                <b>类型二，此菜单挂接OA系统中的模块：</b>
                则填写程序路径，格式如：email，则实际对应的路径是：OA安装目录/webroot/general/email，对应的图片是：OA安装目录/webroot/images/menu/email.gif
                <br>        <br>
                <b>类型三，此菜单挂接外部的B/S结构的系统：</b>
                则填写该系统网址，格式如：http://www.yourdomain.com，注意：请一定要以http://开头
                <br>        <br>
                <b>类型四，此菜单挂接外部的C/S结构或单机版系统：</b>
                则填写可执行文件路径，格式如：file://c:/abc.exe，注意：请一定要以file://开头，后面的程序路径用斜杠或反斜杠均可,对应的图片是：OA安装目录/webroot/images/menu/abc.gif
            </td>
        </tr>
        <tr>
            <td nowrap  class="TableControl" colspan="2" align="center">
                <input type="submit" value="确定" class="BigButton MyButton">&nbsp;&nbsp;
                <input type="button" value="返回" class="BigButton MyButton" onClick="history.back();">
            </td>
        </tr>
    </table>
</form>
</body>
</html>