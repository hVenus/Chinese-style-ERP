<?php
require( "../../../include/auth.php" );
//include_once( "inc/utility_org.php" );
//include_once( "inc/utility_org.new.php" );
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo _( "查询用户" );?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script Language="JavaScript">
        function CheckForm(form_action){
            document.form1.action=form_action;
            document.form1.submit();
        }
    </script>
</head>
<body class="bodycolor" topmargin="5" onload="document.form1.USER_ID.focus();">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
    <tr>
        <td class="Big"><img src="<?php echo SITE_URL;?>assets/images/notify_new.gif" align="absmiddle">
            <span class="big3"><?php echo _( "查询用户" );?></span>
        </td>
    </tr>
</table>
<table class="TableBlock" width="90%" align="center">
    <form action="search.php" method="post" name="form1">
        <tr>
            <td nowrap class="TableData" width="120"><?php echo _( "用户名" );?>：</td>
            <td nowrap class="TableData">
                <input type="text" name="USER_ID" class="BigInput" size="20" maxlength="20">&nbsp;
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "真实姓名" );?>：</td>
            <td nowrap class="TableData">
                <input type="text" name="USER_NAME" class="BigInput" size="10" maxlength="10">&nbsp;
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "别名" );?>：</td>
            <td nowrap class="TableData">
                <input type="text" name="BYNAME" class="BigInput" size="10" maxlength="10">&nbsp;
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "性别" );?>：</td>
            <td nowrap class="TableData">
                <select name="SEX" class="BigSelect">
                    <option value=""></option>
                    <option value="0"><?php echo _( "男" );?></option>
                    <option value="1"><?php echo _( "女" );?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "部门" );?>：</td>
            <td nowrap class="TableData">
                <select name="DEPT_ID" class="BigSelect">
                    <option value=""></option>
                    <?php
                    echo dept_tree_all( 0, $DEPT_ID, 1 );
                    if ( $DEPT_ID == 0 )
                    {
                        echo "          <option value=\"0\">";
                        echo _( "离职人员/外部人员" );
                        echo "</option>\r\n";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData"><?php echo _( "角色" );?>：</td>
            <td nowrap class="TableData">
                <select name="USER_PRIV" class="BigSelect">
                    <option value=""></option>
                    <?php
                    $query = "SELECT * from USER_PRIV order by PRIV_NO desc";
                    $cursor = exequery( $connection, $query );
                    while ( $ROW = mysql_fetch_array( $cursor ) )
                    {
                        $USER_PRIV1 = $ROW['USER_PRIV'];
                        $PRIV_NAME = $ROW['PRIV_NAME'];
                        echo "          <option value=\"";
                        echo $USER_PRIV1;
                        echo "\">";
                        echo $PRIV_NAME;
                        echo "</option>\r\n";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData" width="120"><?php echo _( "管理范围" );?>：</td>
            <td nowrap class="TableData">
                <select name="POST_PRIV" class="BigSelect">
                    <option value=""></option>
                    <option value="0"><?php echo _( "本部门" );?></option>
                    <option value="1"><?php echo _( "全体" );?></option>
                    <option value="2"><?php echo _( "指定部门" );?></option>
                </select>
            </td>
        </tr>
        <tr style="display:none;">
            <td nowrap class="TableData"><?php echo _( "是否允许登录OA系统" );?>：</td>
            <td nowrap class="TableData">
                <select name="NOT_LOGIN" class="BigSelect">
                    <option value="2"></option>
                    <option value="0"><?php echo _( "允许" );?></option>
                    <option value="1"><?php echo _( "禁止" );?></option>
                </select>
            </td>
        </tr>
        <tr style="display:none;">
            <td nowrap class="TableData"><?php echo _( "是否允许查看用户列表" );?>：</td>
            <td nowrap class="TableData">
                <select name="NOT_VIEW_USER" class="BigSelect">
                    <option value="2"></option>
                    <option value="0"><?php echo _( "允许" );?></option>
                    <option value="1"><?php echo _( "禁止" );?></option>
                </select>
            </td>
        </tr>
        <tr style="display:none;">
            <td nowrap class="TableData"><?php echo _( "是否允许显示桌面：" );?></td>
            <td nowrap class="TableData">
                <select name="NOT_VIEW_TABLE" class="BigSelect">
                    <option value="2"></option>
                    <option value="0"><?php echo _( "允许" );?></option>
                    <option value="1"><?php echo _( "禁止" );?></option>
                </select>
            </td>
        </tr>
        <tr style="display:none;">
            <td nowrap class="TableData"><?php echo _( "考勤排班类型" );?>：</td>
            <td nowrap class="TableData">
                <select name="DUTY_TYPE" class="BigSelect">
                    <option value=""></option>
                    <?php
                    $query = "SELECT * from ATTEND_CONFIG order by DUTY_TYPE";
                    $cursor = exequery( $connection, $query );
                    while ( $ROW = mysql_fetch_array( $cursor ) )
                    {
                        $DUTY_TYPE = $ROW['DUTY_TYPE'];
                        $DUTY_NAME = $ROW['DUTY_NAME'];
                        echo "          <option value=\"";
                        echo $DUTY_TYPE;
                        echo "\">";
                        echo $DUTY_NAME;
                        echo "</option>\r\n";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr style="display:none;">
            <td nowrap class="TableData" width="120"><?php echo _( "IMA广播权限" );?>：</td>
            <td nowrap class="TableData">
                <select name="CANBROADCAST" class="BigSelect">
                    <option value=""></option>
                    <option value="0"><?php echo _( "无" );?></option>
                    <option value="1"><?php echo _( "有" );?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td nowrap class="TableData" width="120"><?php echo _( "按最后登录时间排序" );?>：</td>
            <td nowrap class="TableData">
                <select name="LAST_VISIT_TIME" class="BigSelect">
                    <option value=""></option>
                    <option value="desc"><?php echo _( "降序" );?></option>
                    <option value="asc"><?php echo _( "升序" );?></option>
                </select>
            </td>
        </tr>
        <tr>
            <td nowrap class="TableControl" colspan="2" align="center">
                <input type="button" value="<?php echo _( "查询" );?>" class="MyButton BigButton" onclick="CheckForm('search.php');" title="<?php echo _( "查询用户" );?>" name="button">&nbsp;&nbsp;
                <input type="button" value="<?php echo _( "导出" );?>" class="MyButton BigButton" onclick="CheckForm('export.php');" title="<?php echo _( "导出用户信息" );?>" name="button">
            </td>
    </form>
</table>
<br>
<?php
message( _( "提示" ), _( "点击左侧部门后，可以新建用户" ) );
?>
</body></html>
