<?php
require( "../../../include/td_core.php" );
require( "../../../include/auth.php" );
//include_once( "inc/utility_org.php" );
//include_once( "inc/utility_org_new.php" );
//include_once( "inc/utility_all.php" );
$PARA_ARRAY = get_sys_para( "LOGIN_USE_DOMAIN" );
while ( list( $PARA_NAME, $PARA_VALUE ) = each( $PARA_ARRAY ) ){
    $$PARA_NAME = $PARA_VALUE;
}
$query = "SELECT * from USER where USER_ID='".$LOGIN_USER_ID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) ){
    $POST_PRIV = $ROW['POST_PRIV'];
}
if ( $DEPT_ID != "" && $DEPT_ID != 0 ){
    $LOCATION_NAME = $SYS_DEPARTMENT[$DEPT_ID]['DEPT_NAME'];
}else if ( $POST_PRIV != 1 ){
    $LOCATION_NAME = _( "未指定" );
}else{
    $query = "SELECT * from UNIT";
    $cursor = exequery( $connection, $query );
    if ( $ROW = mysql_fetch_array( $cursor ) )
    {
        $LOCATION_NAME = $ROW['UNIT_NAME'];
    }
}
?>
<html>
<head>
    <title><?php echo _( "部门/成员单位管理" );?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="/css/oa.css" rel="stylesheet" type="text/css">
    <script src="/inc/js/module.js"></script>
    <script Language="JavaScript">
        function isDigit(s) {
            var patrn=/^[0-9]{1,20}$/;
            if (!patrn.exec(s))
                return false
            return true
        }
        function CheckForm(){
            if(document.form1.DEPT_NO.value=="")   {
                alert("<?php echo _( "部门排序号不能为空！" );?>");
                return (false);
            }
            if( document.form1.DEPT_NO.value.length!=3 || !isDigit(document.form1.DEPT_NO.value) )   {
                alert("<?php echo _( "部门排序号应为3位数字！" );?>");
                return (false);
            }
            if(document.form1.DEPT_NAME.value=="")  {
                alert("<?php echo _( "部门名称不能为空！" );?>");
                return (false);
            }
            <?php if ( $POST_PRIV != 1 ){?>
            if(document.form1.DEPT_PARENT.value=="")   {
                alert("<?php echo _( "请指定上级部门" );?>");
                return (false);
            }
            <?php }?>
            var dn = document.form1.DN;
            if(!dn)
                return true;
            var dn_str = "";
            for(var i=0; i<dn.options.length; i++)   {
                if(dn.options[i].selected)      {
                    dn_str += dn.options[i].value + "\n";
                }
            }
            document.form1.DN_STR.value = dn_str;
            return true;
        }
        function why_view(){
            if(why_dept.style.display=='')
                why_dept.style.display='none';
            else
                why_dept.style.display='';
        }
    </script>
</head>
<body class="bodycolor" topmargin="5" onload="document.form1.DEPT_NO.focus();">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
    <tr>
        <td class="Big">
            <img src="/images/notify_new.gif" height="22" WIDTH="22">
            <span class="big3"><?php echo _( "新建部门/成员单位" );?> - <?php echo _( "当前节点：" );?> [<?php echo $LOCATION_NAME;?>]</span>
        </td>
    </tr>
</table>
<form action="add.php"  method="post" name="form1" onsubmit="return CheckForm();">
    <table class="TableBlock" width="450" align="center">
        <tr>
            <td nowrap class="TableData"><?php echo _( "部门排序号：" );?></td>
            <td nowrap class="TableData">
                <input type="text" name="DEPT_NO" class="BigInput" size="10" maxlength="3">&nbsp;
                <?php echo _( "3位数字，用于同一级次部门排序，不能重复" );?>
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "部门名称：" );?></td>
            <td nowrap class="TableData"><input type="text" name="DEPT_NAME" class="BigInput" size="25" maxlength="25"></td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "电话：" );?></td>
            <td nowrap class="TableData"><input type="text" name="TEL_NO" class="BigInput" size="25" maxlength="25"></td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "传真：" );?></td>
            <td nowrap class="TableData"><input type="text" name="FAX_NO" class="BigInput" size="25" maxlength="25"></td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "部门地址：" );?></td>
            <td nowrap class="TableData"><input type="text" name="DEPT_ADDRESS" class="BigInput" size="40" maxlength="40"></td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "上级部门：" );?></td>
            <td class="TableData">
                <select name="DEPT_PARENT" class="BigSelect">
                    <?php if ( $POST_PRIV == 10000 ){?>
                        <option value="0"><?php echo _( "无" );?></option>
                    <?php }?>
                    <?php echo  my_dept_tree(0, $DEPT_ID, 1 );?>
                </select>
            </td>
        </tr>
        <tbody style="display:<?php if ( $LOGIN_USER_PRIV != "1" || $TD_ORG_LIMIT <= getorgnum( ) ){    echo "none";}?>;">
        <tr style="display:none;">
            <td nowrap class="TableData"><?php echo _( "是否是分支机构：" );?></td>
            <td nowrap class="TableData">
                <input type="checkbox" name="IS_ORG" id="IS_ORG" <?php if ( $IS_ORG == "1" ){    echo " checked";}?>>
                <label for="IS_ORG"><?php echo _( "做为分支机构" );?></label>
            </td>
        </tr>
        </tbody>
        <tr>
            <td nowrap class="TableData"><?php echo _( "部门主管(选填)：" );?></td>
            <td nowrap class="TableData">
                <input type="hidden" name="TO_ID" value="<?php echo $TO_ID;?>">
                <textarea cols="45" name="TO_NAME" rows="1" style="overflow-y:auto;" class="SmallStatic" wrap="yes" readonly><?php echo $TO_NAME;?></textarea>
                <a href="javascript:;" class="orgAdd" onClick="SelectUser('','TO_ID', 'TO_NAME')"><?php echo _( "添加" );?></a>
                <a href="javascript:;" class="orgClear" onClick="ClearUser('TO_ID', 'TO_NAME')"><?php echo _( "清空" );?></a>
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "部门助理(选填)：" );?></td>
            <td nowrap class="TableData">
                <input type="hidden" name="ASSISTANT_ID" value="<?php echo $ASSISTANT_ID;?>">
                <textarea cols="45" name="ASSISTANT_NAME" rows="1" style="overflow-y:auto;" class="SmallStatic" wrap="yes" readonly><?php echo $ASSISTANT_NAME;?></textarea>
                <a href="javascript:;" class="orgAdd" onClick="SelectUser('','ASSISTANT_ID', 'ASSISTANT_NAME')"><?php echo _( "添加" );?></a>
                <a href="javascript:;" class="orgClear" onClick="ClearUser('ASSISTANT_ID', 'ASSISTANT_NAME')"><?php echo _( "清空" );?></a>
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "上级主管领导(选填)：" );?></td>
            <td nowrap class="TableData">
                <input type="hidden" name="TO_ID3" value="<?php echo $TO_ID3;?>">
                <textarea cols="45" name="TO_NAME3" rows="1" style="overflow-y:auto;" class="SmallStatic" wrap="yes" readonly><?php echo $TO_NAME3;?></textarea>
                <a href="javascript:;" class="orgAdd" onClick="SelectUser('','TO_ID3', 'TO_NAME3')"><?php echo _( "添加" );?></a>
                <a href="javascript:;" class="orgClear" onClick="ClearUser('TO_ID3', 'TO_NAME3')"><?php echo _( "清空" );?></a>
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "上级分管领导(选填)：" );?></td>
            <td nowrap class="TableData">
                <input type="hidden" name="TO_ID4" value="<?php echo $TO_ID4;?>">
                <textarea cols="45" name="TO_NAME4" rows="1" style="overflow-y:auto;" class="SmallStatic" wrap="yes" readonly><?php echo $TO_NAME4;?></textarea>
                <a href="javascript:;" class="orgAdd" onClick="SelectUser('','TO_ID4', 'TO_NAME4')"><?php echo _( "添加" );?></a>
                <a href="javascript:;" class="orgClear" onClick="ClearUser('TO_ID4', 'TO_NAME4')"><?php echo _( "清空" );?></a>
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "部门职能：" );?></td>
            <td nowrap class="TableData"><textarea name="DEPT_FUNC" class="SmallInput" cols="60" rows="5"></textarea></td>
        </tr>
        <tr>
            <td nowrap  class="TableControl" colspan="2" align="center">
                <input type="hidden" value="" name="DN_STR">
                <input type="submit" value="<?php echo _( "新建" );?>" class="MyButton BigButton" title="<?php echo _( "新建" );?>" name="button">
            </td>
        </tr>
    </table>
</form>
</body>
</html>

