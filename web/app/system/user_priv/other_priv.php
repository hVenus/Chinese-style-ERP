<?php
require( "../../../include/auth.php" );
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo _( "添加/删除辅助角色" );?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script src="<?php echo SITE_URL;?>assets/js/module.js"></script>
    <script>
        var check_all_var=true;
        function select_all()  {
            var cb = document.getElementsByName("USER_PRIV");
            if(!cb || cb.length==0)
                return;
            for (i=0;i<document.all("USER_PRIV").length;i++)   {
                if(check_all_var)
                    cb[i].checked=true;
                else
                    cb[i].checked=false;
            }
            check_all_var=!check_all_var;
        }
        function mysubmit()  {
            if(document.form1.TO_ID.value=="")    {
                alert("<?php echo _( "请选择人员" );?>");
                return;
            }
            var user_priv_str="", user_priv=document.getElementsByName("USER_PRIV");
            for(i=0;i<user_priv.length;i++)    {
                if(user_priv[i].checked)
                    user_priv_str+=user_priv[i].value+",";
            }
            if(user_priv_str=="")    {
                alert("<?php echo _( "请选择角色" );?>");
                return;
            }
            document.form1.USER_PRIV_STR.value=user_priv_str;
            form1.submit();
        }
    </script>
</head>
<body class="bodycolor" topmargin="5">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
    <tr>
        <td class="Big">
            <img src="<?php echo SITE_URL;?>assets/images/edit.gif" WIDTH="22" HEIGHT="20" align="absmiddle">
            <span class="big3"><?php echo _( "添加/删除辅助角色" );?></span>
        </td>
    </tr>
</table>
<form method="post" name="form1" action="add_remove_other_priv.php">
    <table class="TableBlock" width="560" align="center">
        <tr class="TableData">
            <td nowrap width="80"><?php echo _( "操作：" );?></td>
            <td>
                <input type="radio" name="OPERATION" value="0" id="OPERATION0" checked>
                <label for="OPERATION0"><?php echo _( "添加辅助角色" );?></label>
                <input type="radio" name="OPERATION" value="1" id="OPERATION1">
                <label for="OPERATION1"><?php echo _( "删除辅助角色" );?></label>
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "人员：" );?></td>
            <td class="TableData">
                <input type="hidden" name="TO_ID" value="">
                <textarea cols=45 name="TO_NAME" rows=4 class="BigStatic" wrap="yes" readonly></textarea>
                <a href="javascript:;" class="orgAdd" onClick="SelectUser('','TO_ID', 'TO_NAME')"><?php echo _( "添加" );?></a>
                <a href="javascript:;" class="orgClear" onClick="ClearUser('TO_ID', 'TO_NAME')"><?php echo _( "清空" );?></a>
            </td>
        </tr>
        <tr class="TableData">
            <td nowrap>
                <?php echo _( "角色：" );?>
                <a href="javascript:select_all();"><u><?php  echo _( "全选" );?></u></a>
            </td>
            <td>
                <?php
                $query = "SELECT * from USER_PRIV order by PRIV_NO";
                $cursor = exequery( $connection, $query );
                while ( $ROW = mysql_fetch_array( $cursor ) ){
                    $USER_PRIV = $ROW['USER_PRIV'];
                    $PRIV_NAME = $ROW['PRIV_NAME'];
                    ?>
                    <input type="checkbox" name="USER_PRIV" value="<?php echo $USER_PRIV;?>" id="USER_PRIV<?php echo $USER_PRIV;?>">
                    <label for="USER_PRIV<?php echo $USER_PRIV;?>"><?php echo $PRIV_NAME;?></label>
                <?php }?>
            </td>
        </tr>
        <tr class="TableControl">
            <td colspan="2" align="center">
                <input type="button" value="<?php echo _( "确定" );?>" class="MyButton BigButton" onclick="mysubmit();">
            </td>
        </tr>
        <input type="hidden" name="USER_PRIV_STR" value="">
    </table>
</form>
<?php message( "", _( "为所选择的人员添加或删除指定的辅助角色" ) );?>
</body>
</html>