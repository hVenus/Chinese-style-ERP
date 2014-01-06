<?php
require( "../../../include/auth.php" );
require( "../../../include/core.php" );
?>
<html>
<head>
    <title><?php  echo _( "角色管理" );?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script src="<?php echo SITE_URL;?>assets/js/dialog.js"></script>
    <script>
        function delete_priv(USER_PRIV){
            msg="<?php echo _( "确认要删除该角色吗？" );?>";
            if(window.confirm(msg)) {
                URL="delete.php?USER_PRIV="+USER_PRIV;
                window.location=URL;
            }
        }
        function detail(USER_PRIV){
            URL="show_users.php?USER_PRIV="+USER_PRIV;
            myleft=(screen.availWidth-800)/2;
            window.open(URL,"","height=500,width=800,status=0,toolbar=no,menubar=no,location=no,scrollbars=yes,top=150,left="+myleft+",resizable=yes");
        }
    </script>
</head>
<body class="bodycolor" topmargin="5" >
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
    <tr>
        <td class="Big">
            <img src="<?php echo SITE_URL;?>assets/images/notify_open.gif" WIDTH="22" HEIGHT="20" align="absmiddle">
            <span class="big3"><?php echo _( "管理角色" );?></span>
<!--            &nbsp;&nbsp;-->
<!--            --><?php //echo iask( "sys_user_priv", 1 );?>
        </td>
        <td align="right">

        </td>
    </tr>
</table>
<br>
<div align="center">
    <table class="TableList" width="100%" border="0" cellPadding="0" cellSpacing="1" bgcolor="#6386d6">
        <thead class="TableHeader">
        <tr bgcolor="#EFF3F7">
            <td nowrap align="center"><?php echo _( "角色排序号" );?></td>
            <td nowrap align="center"><?php echo _( "角色名称" );?></td>
            <td nowrap align="center"><?php echo _( "主角色总用户数(禁止登录用户数)/辅助角色用户数" );?></td>
            <td nowrap align="center"><?php echo _( "操作" );?></td>
        </tr>
        </thead>
        <?php
        $query = "SELECT * from USER_PRIV order by PRIV_NO";
        $cursor = exequery( $connection, $query );
        $PRIV_COUNT = 0;
        while ( $ROW = mysql_fetch_array( $cursor ) ){
            $PRIV_COUNT++;
            $USER_PRIV = $ROW['USER_PRIV'];
            $PRIV_NO = $ROW['PRIV_NO'];
            $PRIV_NAME = $ROW['PRIV_NAME'];
            $USER_COUNT1 = 0;
            $USER_COUNT2 = 0;
            $query = "SELECT count(*) from USER where USER_PRIV='".$USER_PRIV."'";
            $cursor1 = exequery( $connection, $query );
            if ( $ROW1 = mysql_fetch_array( $cursor1 ) ){
                $USER_COUNT1 = $ROW1[0];
            }
            $query = "SELECT count(*) from USER where USER_PRIV='".$USER_PRIV."' and NOT_LOGIN='1'";
            $cursor1 = exequery( $connection, $query );
            if ( $ROW1 = mysql_fetch_array( $cursor1 ) ){
                $USER_COUNT2 = $ROW1[0];
            }
            $query = "SELECT count(*) from USER where FIND_IN_SET('".$USER_PRIV."',USER_PRIV_OTHER)";
            $cursor1 = exequery( $connection, $query );
            if ( $ROW1 = mysql_fetch_array( $cursor1 ) ){
                $USER_COUNT3 = $ROW1[0];
            }
            ?>
            <tr class="TableData" bgcolor="#EFF3F7">
                <td nowrap align="center" width="60"><?php echo $PRIV_NO;?></td>
                <td nowrap align="center"><?php if ( $USER_PRIV == 1 ){?><font color=red><?php }?><?php echo $PRIV_NAME;?></td>
                <td nowrap align="center">
                    <?php echo $USER_COUNT1;?>(<?php echo $USER_COUNT2;?>)/<?php echo $USER_COUNT3;?>&nbsp;&nbsp;
                    <a href="javascript:detail('<?php echo $USER_PRIV;?>');"><?php echo _( "查看详情" );?></a>
                </td>
                <td nowrap align="center">
                    &nbsp;&nbsp;
                    <a href="edit.php?USER_PRIV=<?php echo $USER_PRIV;?>"><?php echo _( "编辑" );?></a>
                    &nbsp;&nbsp;
                    <a href="edit_priv.php?USER_PRIV=<?php echo $USER_PRIV;?>"><?php echo _( "设置权限" );?></a>
                    &nbsp;&nbsp;
                    <a href="clone?USER_PRIV=<?php echo $USER_PRIV;?>"><?php echo _( "克隆" );?></a>
                    &nbsp;&nbsp;
                    <?php if ( $USER_PRIV != 1 ){?>
                        <a href="javascript:delete_priv('<?php echo $USER_PRIV;?>');"><?php echo _( "删除" );?></a>
                    <?php }?>
                </td>
            </tr>
        <?php }?>
    </table>

    <?php if ( 0 == $PRIV_COUNT )    {?>
        <?php message( "", _( "尚未定义" ) );?>
    <?php }?>

</div>
</body>
</html>