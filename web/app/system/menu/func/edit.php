<?php
require( "../../../../include/auth.php" );
require( "../../../../include/sys_function_all.php" );
?>
<html>
<head>
    <title>菜单编辑</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script Language="JavaScript">
        function CheckForm(){
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
$FUNC_ID1 = isset($_GET['FUNC_ID1'])?$_GET['FUNC_ID1']:"";
$query = "SELECT * from SYS_FUNCTION where FUNC_ID='".$FUNC_ID1."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) ){
    $MENU_ID = $ROW['MENU_ID'];
    $FUNC_NAME = $ROW['FUNC_NAME'];
    $FUNC_CODE = $ROW['FUNC_CODE'];
    $OPEN_WINDOW = substr( $FUNC_CODE, 0, 2 ) == "1:" ? 1 : 0;
    $FUNC_CODE = substr( $FUNC_CODE, 0, 2 ) == "1:" ? substr( $FUNC_CODE, 2 ) : $FUNC_CODE;
    $FUNC_EXT = unserialize( $ROW['FUNC_EXT'] );
    $ACCESS_TYPE = $ROW['ACCESS_TYPE'];
    $LANGUAGE_TYPE = $ROW['LANGUAGE_TYPE'];
}
?>
<body class="bodycolor" topmargin="5">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
    <tr>
        <td class="Big">
            <img src="<?php echo SITE_URL;?>assets/images/edit.gif" WIDTH="22" HEIGHT="20" align="absmiddle">
            <span class="big3">编辑子菜单项</span>
        </td>
    </tr>
</table>
<br>
<form action="update.php"  method="post" name="form1" onSubmit="return CheckForm();">
    <table class="TableBlock" width="450" align="center">
        <tr>
            <td nowrap class="TableData" width="120">子菜单项ID：</td>
            <td nowrap class="TableData">
                <input type="text" name="FUNC_ID1" class="BigStatic" size="20" maxlength="50" value="<?php  echo $FUNC_ID1;?>" readonly>
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
                            <option value="<?php echo $ITEM_ID;?>" <?php if ( substr( $MENU_ID, 0, -2 ) == $ITEM_ID ){ echo " selected"; }?> ><?php  echo $ITEM_NAME;?></option>
                            <?php
                            $child = Menu::getChildMenu($SYS_FUNCTION, $ITEM_ID);
                            foreach($child as $child_item){
                                $child_item_id = $child_item['MENU_ID'];
                                $child_item_name = $child_item['FUNC_NAME'];
                                $child_item_code = $child_item['FUNC_CODE'];
                                if(substr($child_item_code, 0, 1)=='@'){
                            ?>
                                    <option value="<?php echo $child_item_id;?>" <?php if ( substr( $MENU_ID, 0, -2 ) == $child_item_id ){ echo " selected"; }?> >&nbsp;&nbsp;├<?php  echo $child_item_name;?></option>
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
                <input type="text" name="MENU_ID" class="BigInput" size="20" maxlength="2" value="<?php  echo substr( $MENU_ID, -2 );?>">
                <br>
                说明：此代码为两位，作为排序之用。在同一父菜单下的平级菜单，该代码不能重复
            </td>
        </tr>
        <?php
        $LANG_ARRAY = get_lang_array_new( );
        foreach ( $LANG_ARRAY as $LANG => $LANG_DESC ){
            $FUNC_NAME_EXT = "";
            if ( $LANG == $MYOA_DEFAULT_LANG ){
                $FUNC_NAME_EXT = $FUNC_NAME;
            }else if ( is_array( $FUNC_EXT ) && $FUNC_EXT[$LANG] != "" ){
                $FUNC_NAME_EXT = $FUNC_EXT[$LANG];
            }
            ?>
            <tr>
                <td nowrap class="TableData">子菜单名称：(<?php echo $LANG_DESC;?>)</td>
                <td nowrap class="TableData">
                    <input type="text" name="FUNC_NAME_<?php echo bin2hex( $LANG );?>" class="BigInput" size="20" maxlength="50" value="<?php echo $FUNC_NAME_EXT;?>">
                </td>
            </tr>
            <?php }?>
        <tr>
            <td nowrap class="TableData">子菜单模块路径：</td>
            <td class="TableData">
                <input type="text" name="FUNC_CODE1" class="BigInput" size="40" value="<?php  echo $FUNC_CODE;?>">&nbsp;
                <input type="checkbox" name="OPEN_WINDOW" id="OPEN_WINDOW" <?php  if ( $OPEN_WINDOW == 1 )    {    echo " checked";    }?>>
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
                <br><br>
                <b>类型三，此菜单挂接外部的B/S结构的系统：</b>
                则填写该系统网址，格式如：http://www.yourdomain.com，注意：请一定要以http://开头
                <br><br>
                <b>类型四，此菜单挂接外部的C/S结构或单机版系统：</b>
                则填写可执行文件路径，格式如：file://c:/abc.exe，注意：请一定要以file://开头，后面的程序路径用斜杠或反斜杠均可,对应的图片是：OA安装目录/webroot/images/menu/abc.gif
            </td>
        </tr>
        <tr>
            <td nowrap  class="TableControl" colspan="2" align="center">
                <input type="submit" value="确定" class="BigButton">&nbsp;&nbsp;
                <input type="button" value="返回" class="BigButton" onClick="history.back();">
            </td>
        </tr>
    </table>
</form>
</body>
</html>