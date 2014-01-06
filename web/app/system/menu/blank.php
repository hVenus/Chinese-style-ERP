<?php
require( "../../../include/auth.php" );
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <style type="text/css">
    .msg-content{text-align: left;margin:10px;}
    </style>
</head>
<body class="bodycolor" topmargin="5">
<table width="100%" border="0" cellPadding="0" cellSpacing="0" borderColor="#ffffff" bgColor="#dee7ff" >
    <tbody>
    <tr height="35">
        <td align="middle" width="20"   bgColor="#dee7ff"></td>
        <td align="middle" width="120"  bgColor=#dee7ff>菜单设置&nbsp;</td>
        <td align="middle" width="11"  bgColor=#dee7ff>&nbsp; </td>
        <td align="middle"  bgColor=#dee7ff>&nbsp;</td>
    </tr>
    </tbody>
</table>
<?php message( _( "菜单定义简明指南" ),  "\r\n1、通过灵活定义菜单，可以挂接外部的B/S、C/S或单机版系统。<br><br>\r\n2、子菜单项ID是菜单的唯一性标识，应避免重复；子菜单项代码用于表示子菜单项在其所属层次中的位置，子菜单项代码为两位数字。<br><br>\r\n3、同一层次的菜单项代码建议保留一定间隔，以方便日后在中间插入菜单项。<br><br>\r\n4、新增的菜单项，只有进行角色权限设置后才能看到。\r\n\r\n\r\n"  );?>
</body>
</html>