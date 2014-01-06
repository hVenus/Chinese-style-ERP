<?php
require( "../../../include/auth.php" );
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body class="bodycolor" topmargin="5">
<table width="100%" border="0" cellPadding="0" cellSpacing="0" borderColor="#ffffff" bgColor="#dee7ff" style="FONT-SIZE: 10pt">
    <tbody>
    <tr height="35">
        <td align="middle" width="20" background="<?php echo SITE_URL;?>assets/images/title_left.gif"  bgColor="#dee7ff"></td>
        <td align="middle" width="120" background="<?php echo SITE_URL;?>assets/images/title_left.gif" bgColor="#dee7ff">
            <FONT color="#f7f7f7"><?php echo _('部门管理');?>&nbsp;</FONT>
        </td>
        <td align=middle width=11 background="<?php echo SITE_URL;?>assets/images/title_middle.gif" bgColor="#dee7ff">&nbsp;</td>
        <td align=right background="<?php echo SITE_URL;?>assets/images/title_right.gif" bgColor="#dee7ff">
            <input type="button" value="新建部门" class="MyButton BigButton" onClick="parent.dept_main.location='dept_new.php';" title="<?php echo _('新建部门');?>">
            &nbsp;&nbsp;&nbsp;
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>