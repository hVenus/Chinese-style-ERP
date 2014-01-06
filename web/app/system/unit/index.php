<?php
require( "../../../include/auth.php" );
$query = "SELECT * from UNIT";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
    $UNIT_NAME = $ROW['UNIT_NAME'];
    $TEL_NO = $ROW['TEL_NO'];
    $FAX_NO = $ROW['FAX_NO'];
    $POST_NO = $ROW['POST_NO'];
    $ADDRESS = $ROW['ADDRESS'];
    $UNIT_URL = $ROW['URL'];
    $EMAIL = $ROW['EMAIL'];
    $BANK_NAME = $ROW['BANK_NAME'];
    $BANK_NO = $ROW['BANK_NO'];
    $ATTACHMENT_ID = $ROW['ATTACHMENT_ID'];
    $ATTACHMENT_NAME = $ROW['ATTACHMENT_NAME'];
    $CONTENT = $ROW['CONTENT'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo _( "单位管理" );?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script Language="JavaScript">
        var upload_limit=<?php echo $UPLOAD_LIMIT;?>,limit_type="<?php echo strtolower( $UPLOAD_LIMIT_TYPE );?>";
        function InsertImage(src){
            AddImage2Editor('CONTENT', src);
        }

        function IsNumber(str){
            return str.match(/^[0-9]*$/)!=null;
        }
        function IsValidEmail(str){
            var re = /@/;
            return str.match(re)!=null;
        }
        function CheckForm(){
            if (document.form1.UNIT_NAME.value=="")   {
                alert("<?php echo _( "单位名称不能为空！" );?>");
                return (false);
            }
            if (document.form1.POST_NO.value!=""&&!IsNumber(document.form1.POST_NO.value))   {
                alert("<?php echo _( "邮编只能是数字！" );?>");
                return (false);
            }
            if (document.form1.EMAIL.value!=""&&!IsValidEmail(document.form1.EMAIL.value))   {
                alert("<?php echo _( "请输入有效的电子信箱！" );?>");
                return (false);
            }
        }
    </script>
</head>
<body class="bodycolor" topmargin="5" onload="document.form1.UNIT_NAME.focus();">
<TABLE width="100%" border=0 cellPadding=0 cellSpacing=0 borderColor=#ffffff bgColor=#dee7ff >
    <TBODY>
    <TR height=35>
        <TD align=middle width=20 background="<?php echo SITE_URL;?>assets/images/title_left.gif"  bgColor="#dee7ff"></TD>
        <TD align=middle width=120 background="<?php echo SITE_URL;?>assets/images/title_left.gif" bgColor=#dee7ff><FONT color=#f7f7f7><?php echo _( "单位管理" );?><font color="#FFFFFF">&nbsp;</font></FONT> </TD>
        <TD align=middle width=11 background="<?php echo SITE_URL;?>assets/images/title_middle.gif" bgColor=#dee7ff><FONT color=#f7f7f7>&nbsp;</FONT> </TD>
        <TD align=middle background="<?php echo SITE_URL;?>assets/images/title_right.gif" bgColor=#dee7ff><FONT color=#f7f7f7>&nbsp;</FONT> </TD>
    </TR>
    </TBODY>
</TABLE>
<form enctype="multipart/form-data" action="update.php"  method="post" name="form1" onsubmit="return CheckForm();">
    <table class="TableBlock" width="90%" align="center">
        <tr>
            <td nowrap class="TableData"><?php echo _( "单位名称：" );?></td>
            <td nowrap class="TableData">
                <input type="text" name="UNIT_NAME" class="BigInput" size="40" value="<?php echo $UNIT_NAME;?>">
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "电话：" );?></td>
            <td nowrap class="TableData"><input type="text" name="TEL_NO" class="BigInput" size="40" value="<?php echo $TEL_NO;?>"></td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "传真：" );?></td>
            <td nowrap class="TableData"><input type="text" name="FAX_NO" class="BigInput" size="40" value="<?php echo $FAX_NO;?>"></td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "邮编：" );?></td>
            <td nowrap class="TableData"><input type="text" name="POST_NO" class="BigInput" size="40" value="<?php echo $POST_NO;?>"></td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "地址：" );?></td>
            <td nowrap class="TableData"><input type="text" name="ADDRESS" class="BigInput" size="40" value="<?php echo $ADDRESS;?>"></td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "网站：" );?></td>
            <td nowrap class="TableData"><input type="text" name="URL" class="BigInput" size="40" value="<?php echo $UNIT_URL;?>"></td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "电子信箱：" );?></td>
            <td nowrap class="TableData"><input type="text" name="EMAIL" class="BigInput" size="40" value="<?php echo $EMAIL;?>"></td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "开户行：" );?></td>
            <td nowrap class="TableData"><input type="text" name="BANK_NAME" class="BigInput" size="40" value="<?php echo $BANK_NAME;?>"></td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "账号：" );?></td>
            <td nowrap class="TableData"><input type="text" name="BANK_NO" class="BigInput" size="40" value="<?php echo $BANK_NO;?>"></td>
        </tr>
        <tr>
            <td nowrap class="TableData" colspan="2" ><b><?php echo _( "单位简介" );?></b></td>
        </tr>
        <tr id="EDITOR">
            <td class="TableData" colspan="2">
                <textarea name="CONTENT" rows="8" cols="60" style="height:350px;width:100%;"><?php echo $CONTENT;?></textarea>
            </td>
        </tr>
        <tr>
            <td nowrap  class="TableControl" colspan="2" align="center">
                <input type="submit" value="<?php echo _( "保存单位设置" );?>" class="MyButton BigButton">&nbsp;&nbsp;&nbsp;
            </td>
        </tr>
    </table>
</form>
</body>
</html>

