<?php
require( "../../../include/td_core.php" );
require( "../../../include/auth.php" );
//include_once( "inc/utility_org.php" );
//include_once( "inc/utility_org_new.php" );
//include_once( "inc/utility_all.php" );
$PARA_ARRAY = get_sys_para( "LOGIN_USE_DOMAIN" );
while ( list( $PARA_NAME, $PARA_VALUE ) = each( $PARA_ARRAY ) )
{
    $$PARA_NAME = $PARA_VALUE;
}
$query = "SELECT POST_PRIV,POST_DEPT from USER where USER_ID='".$LOGIN_USER_ID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
    $POST_PRIV = $ROW['POST_PRIV'];
    $POST_DEPT = $ROW['POST_DEPT'];
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
            if(document.form1.DEPT_NO.value=="") {
                alert("<?php echo _( "部门排序号不能为空！" );?>");
                return (false);
            }
            if( document.form1.DEPT_NO.value.length!=3 || !isDigit(document.form1.DEPT_NO.value) )   {
                alert("<?php echo _( "部门排序号应为3位数字！" );?>");
                return (false);
            }
            if(document.form1.DEPT_NAME.value=="") {
                alert("<?php echo _( "部门名称不能为空！" );?>");
                return (false);
            }
            <?php if ( $POST_PRIV != 1 ){?>
            if(document.form1.DEPT_PARENT.value=="")  {
                alert("<?php echo _( "请指定上级部门" );?>");
                return (false);
            }
            <?php }?>
            var dn = document.form1.DN;
            if(!dn)
                return true;
            var dn_str = "";
            for(var i=0; i<dn.options.length; i++){
                if(dn.options[i].selected) {
                    dn_str += dn.options[i].value + "\\n";
                }
            }
            document.form1.DN_STR.value = dn_str;
            return true;
        }
        function delete_dept(DEPT_ID){
            msg='<?php echo _( "确认要删除该部门/成员单位吗？这将同时删除所有下级部门和部门中的用户！" );?>';
            if(window.confirm(msg)) {
                url="delete.php?DEPT_ID="+DEPT_ID;
                location=url;
            }
        }
    </script>
</head>
<body class="bodycolor" topmargin="5" onLoad="document.form1.DEPT_NO.focus();">
<?php
$READ_ONLY = 0;
if ( !( $POST_PRIV == "0" ) || $DEPT_ID == $LOGIN_DEPT_ID || $POST_PRIV == "2" && find_id( $POST_DEPT, $DEPT_ID ) ){
    $READ_ONLY = 1;
}
$query = "SELECT * from DEPARTMENT where DEPT_ID='".$DEPT_ID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) ){
    $DEPT_NAME = $ROW['DEPT_NAME'];
    $TEL_NO = $ROW['TEL_NO'];
    $FAX_NO = $ROW['FAX_NO'];
    $DEPT_ADDRESS = $ROW['DEPT_ADDRESS'];
    $DEPT_NO = $ROW['DEPT_NO'];
    $DEPT_PARENT = $ROW['DEPT_PARENT'];
    $TO_ID = $ROW['MANAGER'];
    $ASSISTANT_ID = $ROW['ASSISTANT_ID'];
    $TO_ID3 = $ROW['LEADER1'];
    $TO_ID4 = $ROW['LEADER2'];
    $DEPT_FUNC = $ROW['DEPT_FUNC'];
    $IS_ORG = $ROW['IS_ORG'];
}
$TO_ARRAY = array( );
$query1 = "SELECT USER_ID,USER_NAME from USER where find_in_set(USER_ID,'".$TO_ID."')";
$cursor1 = exequery( $connection, $query1 );
while ( $ROW = mysql_fetch_array( $cursor1 ) ){
    $TO_ARRAY[$ROW['USER_ID']]['USER_NAME'] = $ROW['USER_NAME'];
}
$TOK = strtok( $TO_ID, "," );
while ( $TOK != "" ){
    $TO_NAME .= $TO_ARRAY[$TOK]['USER_NAME'].",";
    $TOK = strtok( "," );
}
$query1 = "SELECT USER_ID,USER_NAME from USER where find_in_set(USER_ID,'".$ASSISTANT_ID."')";
$cursor1 = exequery( $connection, $query1 );
while ( $ROW = mysql_fetch_array( $cursor1 ) ){
    $TO_ARRAY[$ROW['USER_ID']]['USER_NAME'] = $ROW['USER_NAME'];
}
$TOK = strtok( $ASSISTANT_ID, "," );
while ( $TOK != "" ){
    $ASSISTANT_NAME .= $TO_ARRAY[$TOK]['USER_NAME'].",";
    $TOK = strtok( "," );
}
if ( $ASSISTANT_NAME == "," ){
    $ASSISTANT_NAME = "";
}
$query1 = "SELECT USER_ID,USER_NAME from USER where find_in_set(USER_ID,'".$TO_ID3."')";
$cursor1 = exequery( $connection, $query1 );
while ( $ROW = mysql_fetch_array( $cursor1 ) ){
    $TO_ARRAY[$ROW['USER_ID']]['USER_NAME'] = $ROW['USER_NAME'];
}
$TOK = strtok( $TO_ID3, "," );
while ( $TOK != "" ){
    $TO_NAME3 .= $TO_ARRAY[$TOK]['USER_NAME'].",";
    $TOK = strtok( "," );
}
$query1 = "SELECT USER_ID,USER_NAME from USER where find_in_set(USER_ID,'".$TO_ID4."')";
$cursor1 = exequery( $connection, $query1 );
while ( $ROW = mysql_fetch_array( $cursor1 ) ){
    $TO_ARRAY[$ROW['USER_ID']]['USER_NAME'] = $ROW['USER_NAME'];
}
$TOK = strtok( $TO_ID4, "," );
while ( $TOK != "" ){
    $TO_NAME4 .= $TO_ARRAY[$TOK]['USER_NAME'].",";
    $TOK = strtok( "," );
}
?>
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
    <tr>
        <td class="Big">
            <img src="/images/edit.gif" width="20" HEIGHT="22">
            <span class="big3"><?php echo _( "编辑部门/成员单位" );?> - [<?php echo $DEPT_NAME;?>]</span>
        </td>
    </tr>
</table>
<form action="update.php"  method="post" name="form1" onSubmit="return CheckForm();">
    <table class="TableBlock" width="500" align="center">
        <tr>
            <td nowrap class="TableData"><?php echo _( "部门排序号：" );?></td>
            <td nowrap class="TableData">
                <input type="text" name="DEPT_NO" class="<?php echo $READ_ONLY ? "BigStatic" : "BigInput";?>" size="10" maxlength="3" value="<?php echo substr( $DEPT_NO, -3 );?>" <?php echo $READ_ONLY ? " readonly" : "";?>>
                &nbsp;
                <?php echo _( "3位数字，用于同一级次部门排序，不能重复" );?>
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "部门名称：" );?></td>
            <td nowrap class="TableData">
                <input type="text" name="DEPT_NAME" class="BigInput" size="25" maxlength="25" value="<?php echo $DEPT_NAME;?>">
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "电话：" );?></td>
            <td nowrap class="TableData">
                <input type="text" name="TEL_NO" class="BigInput" size="25" maxlength="25" value="<?php echo $TEL_NO;?>">
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "传真：" );?></td>
            <td nowrap class="TableData">
                <input type="text" name="FAX_NO" class="BigInput" size="25" maxlength="25" value="<?php echo $FAX_NO;?>">
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "地址：" );?></td>
            <td nowrap class="TableData">
                <input type="text" name="DEPT_ADDRESS" class="BigInput" size="40" maxlength="40" value="<?php echo $DEPT_ADDRESS;?>">
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "上级部门：" );?></td>
            <td class="TableData">
                <select name="DEPT_PARENT" class="BigSelect">
                    <?php if ( $POST_PRIV == 1 ){?>
                        <option value="0"><?php echo _( "无" );?></option>
                    <?php }?>
                    <?php
                    $DEPT_STR = my_dept_tree( 0, $DEPT_PARENT, 1, $DEPT_ID );
                    //$DEPT_STR = dept_tree_all_new( 0, $DEPT_PARENT, 1, $DEPT_ID);
                    $POS1 = strpos( $DEPT_STR, "<option value=".$DEPT_ID.">" );
                    $POS2 = strpos( $DEPT_STR, "</option>", $POS1 );
                    $DEPT_STR1 = substr( $DEPT_STR, $POS1, $POS2 - $POS1 + 9 );
                    $DEPT_STR = str_replace( $DEPT_STR1, "", $DEPT_STR );
                    if ( $POST_PRIV != 1 && trim( $DEPT_STR ) == "" ){
                        $DEPT_STR = "<option value=\"".$DEPT_PARENT."\">".$SYS_DEPARTMENT[$DEPT_PARENT]['DEPT_NAME']."</option>";
                    }
                    echo $DEPT_STR;
                    ?>
                </select>
            </td>
        </tr>
        <tbody style="display:<?php if ( $LOGIN_USER_PRIV != "1" ){    echo "none";}?>;">
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
            <td nowrap class="TableData">
                <textarea name="DEPT_FUNC" class="SmallInput" cols="60" rows="5"><?php echo $DEPT_FUNC;?></textarea>
            </td>
        </tr>
        <tr>
            <td nowrap  class="TableControl" colspan="2" align="center">
                <input type="hidden" name="DEPT_ID" value="<?php echo $DEPT_ID;?>">
                <input type="hidden" value="" name="DN_STR">
                <input type="submit" value="<?php echo _( "保存修改" );?>" class="MyButton BigButton" title="<?php echo _( "保存修改" );?>" name="button">
            </td>
        </tr>
    </table>
</form>
<br>
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
    <tr>
        <td class="Big">
            <img src="/images/menu/system.gif" WIDTH="22" HEIGHT="20" align="absmiddle">
            <span class="big3"><?php echo _( "当前部门/成员单位" );?> - <?php echo _( "相关操作" );?></span>
        </td>
    </tr>
</table>
<br>
<div align="center">
    <input type="button" value="<?php echo _( "新建下级部门/成员单位" );?>" class="MyButton BigButton" onClick="location='dept_new.php?DEPT_ID=<?php echo $DEPT_ID;?>';" title="<?php echo _( "新建下级部门/成员单位" );?>">
    <br>
    <br>
    <input type="button" value="<?php echo _( "删除当前部门/成员单位" );?>" class="MyButton BigButton" onClick="delete_dept('<?php echo $DEPT_ID;?>')" title="<?php echo _( "删除当前部门/成员单位" );?>">
</div>
</body>
</html>

