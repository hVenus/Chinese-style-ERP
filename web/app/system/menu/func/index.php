<?php
require( "../../../../include/auth.php" );
?>
<!DOCTYPE html>
<html>
<head>
    <title>菜单设置</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script>
        if(typeof(sprintf) != "function"){
    function sprintf(str){
        var array = str.split("%s");
        if(array.length == 1 || array.length != arguments.length)
            return str;
        str = array[0];
        for(var i=1; i < array.length; i++){
            str += arguments[i] + array[i];
        }
        return str;
    }
}
    </script>
    <script Language="JavaScript">
        function delete_menu(MENU_ID,FUNC_ID,FUNC_NAME){
            var msg = sprintf("确认要删除子菜单项 '%s' 吗？", FUNC_NAME);
            if(window.confirm(msg)){
                URL="delete.php?MENU_ID=" + MENU_ID+"&FUNC_ID1="+FUNC_ID;
                location=URL;
            }
        }
    </script>
</head>
<body class="bodycolor" topmargin="5">

<table width="100%" border=0 cellPadding=0 cellSpacing=0 borderColor=#ffffff bgColor=#dee7ff >
    <tbody>
    <tr height=35>
        <td align=middle width=20 background="/images/title_left.gif"  bgColor="#dee7ff"></td>
        <td align=middle width=120 background="/images/title_left.gif" bgColor=#dee7ff><FONT color=#f7f7f7>子菜单项设置<font color="#FFFFFF">&nbsp;</font></FONT> </td>
        <td align=middle width=11 background="/images/title_middle.gif" bgColor=#dee7ff><FONT color=#f7f7f7>&nbsp;</FONT> </td>
        <td align=middle background="/images/title_right.gif" bgColor=#dee7ff><FONT color=#f7f7f7>&nbsp;</FONT> </td>
    </tr>
    </tbody>
</table>
<?php
$query = "SELECT * from SYS_MENU where MENU_ID='".$_GET['MENU_ID']."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) ){
    $MENU_NAME = $ROW['MENU_NAME'];
    $IMAGE = $ROW['IMAGE'];
    $MENU_EXT = unserialize( $ROW['MENU_EXT'] );
    if ( is_array( $MENU_EXT ) && $MENU_EXT[$LANG_COOKIE] != "" ){
        $MENU_NAME = $MENU_EXT[$LANG_COOKIE];
    }
}
?>
<table class="TableBlock" align="center">
    <tr class="TableHeader">
        <td nowrap title="<?php echo $MENU_NAME;?>" colspan="2">
            <img src="/images/menu/<?php echo $IMAGE;?>.gif" width="16" height="16">&nbsp;&nbsp;<b><?php echo $MENU_NAME;?></b>
        </td>
    </tr>
    <tr>
        <td class="TableHeader" align="center" colspan="2">
            <input type="button" value="增加子菜单项" class="BigButton MyButton" onClick="parent.menu_edit.location='new.php?MENU_ID=<?php echo $_GET['MENU_ID'];?>';">
        </td>
    </tr>
    <?php
    $query1 = "SELECT * from SYS_FUNCTION where MENU_ID like '".$_GET['MENU_ID']."%' and length(MENU_ID)=4 order by MENU_ID";
    $cursor1 = exequery( $connection, $query1 );
    while($ROW = mysql_fetch_array( $cursor1 )){
        $MENU_ID = $ROW['MENU_ID'];
        $FUNC_ID = $ROW['FUNC_ID'];
        $FUNC_NAME = $ROW['FUNC_NAME'];
        $FUNC_CODE = $ROW['FUNC_CODE'];
        $FUNC_EXT = unserialize( $ROW['FUNC_EXT'] );
        if ( is_array( $FUNC_EXT ) && $FUNC_EXT[$LANG_COOKIE] != "" ){
            $FUNC_NAME = $FUNC_EXT[$LANG_COOKIE];
        }
        $OPEN_WINDOW = substr( $FUNC_CODE, 0, 2 ) == "1:" ? 1 : 0;
        $FUNC_CODE = $ROW['FUNC_CODE'];
        $FUNC_CODE = substr( $FUNC_CODE, 0, 2 ) == "1:" ? substr( $FUNC_CODE, 2 ) : $FUNC_CODE;
        if ( 10000 <= $FUNC_ID && $FUNC_ID <= 20000 ){
            $FUNC_IMAGE = "fis";
        }else if ( strstr( $FUNC_CODE, "http://" ) ){
            $FUNC_IMAGE = "menu_url";
        }else if ( strstr( $FUNC_CODE, "https://" ) ){
            $FUNC_IMAGE = "https";
        }else if ( strstr( $FUNC_CODE, "file://" ) ){
            $STR_LEN = strpos( $FUNC_CODE, ".exe" ) - strrpos( $FUNC_CODE, "/" ) - 1;
            $FUNC_IMAGE = substr( $FUNC_CODE, strrpos( $FUNC_CODE, "/" ) + 1, $STR_LEN );
        }else if ( strstr( $FUNC_CODE, "/" ) ){
            $FUNC_IMAGE = substr( $FUNC_CODE, 0, strpos( $FUNC_CODE, "/" ) );
        }else{
            $FUNC_IMAGE = $FUNC_CODE;
        }
        ?>
        <tr class="TableData">
            <td nowrap title="<?php echo $ROW['FUNC_NAME'];?>" >
                <img src="/images/menu/<?php echo $FUNC_IMAGE;?>.gif" width=16 height=16>&nbsp;<?php echo substr( $ROW['MENU_ID'], -2 );?>&nbsp;
                <b><?php echo $ROW['FUNC_NAME'];?></b>
            </td>
            <td nowrap align="center">
                <a href="edit.php?FUNC_ID1=<?php echo $ROW['FUNC_ID'];?>">编辑</a>&nbsp;&nbsp;
                <a href="javascript:delete_menu('<?php echo $ROW["MENU_ID"];?>','<?php echo $ROW["FUNC_ID"];?>','<?php echo $ROW["FUNC_NAME"];?>');">删除</a>
            </td>
        </tr>
        <?php
        $query2 = "SELECT * from SYS_FUNCTION where MENU_ID like '".$MENU_ID."%' and length(MENU_ID)=6 order by MENU_ID";
        $cursor2 = exequery( $connection, $query2 );
        while($ROW1 = mysql_fetch_array( $cursor2 )){
            $FUNC_ID = $ROW1['FUNC_ID'];
            $MENU_ID = $ROW1['MENU_ID'];
            $FUNC_NAME = $ROW1['FUNC_NAME'];
            $FUNC_CODE = $ROW1['FUNC_CODE'];
            $FUNC_EXT = unserialize( $ROW1['FUNC_EXT'] );
            if ( $FUNC_EXT[$LANG_COOKIE] != "" ){
                $FUNC_NAME = $FUNC_EXT[$LANG_COOKIE];
            }
            $OPEN_WINDOW = 0;
            $FUNC_CODE = $FUNC_CODE;
            if ( $FUNC_ID <= 20000 ){
                $FUNC_IMAGE = "fis";
            }else if ( strstr( $FUNC_CODE, "http://" ) ){
                $FUNC_IMAGE = "menu_url";
            }else if ( strstr( $FUNC_CODE, "file://" ) ){
                $FUNC_IMAGE = "winexe";
            }else if ( strstr( $FUNC_CODE, "/" ) ){
                $FUNC_IMAGE = substr( $FUNC_CODE, 0, strpos( $FUNC_CODE, "/" ) );
            }else{
                $FUNC_IMAGE = $FUNC_CODE;
            }
            if ( $FUNC_CODE == "bbs2/admin" ){
                $FUNC_IMAGE = "system";
            }
            ?>
            <tr class="TableData">
                <td nowrap title="<?php echo $ROW1['FUNC_NAME'];?>">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <img src="/images/menu/<?php echo $FUNC_IMAGE;?>.gif" width=16 height=16>&nbsp;<?php echo substr( $ROW1['MENU_ID'], -2 );?>&nbsp;
                    <b><?php echo $ROW1['FUNC_NAME'];?></b>
                </td>
                <td nowrap align="center">
                    <a href="edit.php?FUNC_ID1=<?php echo $ROW1['FUNC_ID'];?>">编辑</a>&nbsp;&nbsp;
                    <a href="javascript:delete_menu('<?php echo $ROW1["MENU_ID"];?>','<?php echo $ROW1["FUNC_ID"];?>','<?php echo $ROW1["FUNC_NAME"];?>');">删除</a>
                </td>
            </tr>
            <?php
        }
    }
    ?>
</table>
<br>
<div align="center">
    <input type="button" value="返回" class="BigButton MyButton" onClick="location='../blank.php'">
</div>
</body>
</html>