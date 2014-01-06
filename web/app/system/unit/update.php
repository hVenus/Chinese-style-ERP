<?php
require( "../../../include/auth.php" );
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo _( "修改单位" );?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body class="bodycolor" topmargin="5">
<?php
// 直接赋成空值
$ATTACHMENT_ID .= '';
$ATTACHMENT_NAME .= '';
$UNIT_NAME = mysql_real_escape_string($_POST['UNIT_NAME']);
$TEL_NO = mysql_real_escape_string($_POST['TEL_NO']);
$FAX_NO = mysql_real_escape_string($_POST['FAX_NO']);
$POST_NO = mysql_real_escape_string($_POST['POST_NO']);
$ADDRESS = mysql_real_escape_string($_POST['ADDRESS']);
$URL = mysql_real_escape_string($_POST['URL']);
$EMAIL = mysql_real_escape_string($_POST['EMAIL']);
$BANK_NAME = mysql_real_escape_string($_POST['BANK_NAME']);
$BANK_NO = mysql_real_escape_string($_POST['BANK_NO']);
$CONTENT = mysql_real_escape_string($_POST['CONTENT']);

$query = "update UNIT set UNIT_NAME='".$UNIT_NAME."',TEL_NO='{$TEL_NO}',FAX_NO='{$FAX_NO}',POST_NO='{$POST_NO}',ADDRESS='{$ADDRESS}',URL='{$URL}',EMAIL='{$EMAIL}',BANK_NAME='{$BANK_NAME}',BANK_NO='{$BANK_NO}',ATTACHMENT_ID='{$ATTACHMENT_ID}',ATTACHMENT_NAME='{$ATTACHMENT_NAME}',CONTENT='{$CONTENT}'";
exequery( $connection, $query );
?>
<table class="MessageBox" align="center" width="455">
    <tr class="head">
        <td class="left"></td>
        <td class="center">
            <div class="title">提示</div>
        </td>
        <td class="right"></td>
    </tr>
    <tr class="msg">
        <td class="left"></td>
        <td class="center info">
            <div class="msg-content">单位信息已修改</div>
        </td>
        <td class="right"></td>
    </tr>
    <tr class="foot">
        <td class="left"></td>
        <td class="center"></td>
        <td class="right"></td>
    </tr>
</table>
<br><center><input type="button" class="MyButton" value="返回" onclick="history.back();"></center>
</body>
</html>