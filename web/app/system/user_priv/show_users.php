<?php

function dept_tree_list( $DEPT_ID )
{
    global $connection;
    global $DEEP_COUNT;
    global $USER_PRIV;
    global $COUNT1;
    global $COUNT2;
    global $COUNT3;
    global $COUTN_DEPT;
    $query = "SELECT * from DEPARTMENT where DEPT_PARENT='".$DEPT_ID."'  order by DEPT_NO";
    $cursor = exequery( $connection, $query );
    $POSTFIX = _( "，" );
    $OPTION_TEXT = "";
    $DEEP_COUNT1 = $DEEP_COUNT;
    $DEEP_COUNT .= _( "　" );
    while ( $ROW = mysql_fetch_array( $cursor ) ){
        $COUNT++;
        $DEPT_ID = $ROW['DEPT_ID'];
        $DEPT_NAME = $ROW['DEPT_NAME'];
        $DEPT_NAME = htmlspecialchars( $DEPT_NAME );
        $DEPT_PRIV = 1;
        $OPTION_TEXT_CHILD = dept_tree_list( $DEPT_ID );
        $USER_NAME_STR1 = $USER_NAME_STR2 = $USER_NAME_STR3 = "";
        $query1 = "SELECT USER_NAME from USER where USER_PRIV='".$USER_PRIV."' AND DEPT_ID='{$DEPT_ID}'  order by USER_NO,USER_NAME";
        $cursor1 = exequery( $connection, $query1 );
        while ( $ROW1 = mysql_fetch_array( $cursor1 ) ){
            $USER_NAME_STR1 .= $ROW1['USER_NAME'].$POSTFIX;
            $COUNT1++;
            $COUNT_DEPT["{$DEPT_ID}"][1]++;
        }
        $query1 = "SELECT USER_NAME from USER where FIND_IN_SET(".$USER_PRIV.",USER_PRIV_OTHER) AND DEPT_ID='{$DEPT_ID}'  order by USER_NO,USER_NAME";
        $cursor1 = exequery( $connection, $query1 );
        while ( $ROW1 = mysql_fetch_array( $cursor1 ) ){
            $USER_NAME_STR2 .= $ROW1['USER_NAME'].$POSTFIX;
            $COUNT2++;
            $COUNT_DEPT["{$DEPT_ID}"][2]++;
        }
        $query1 = "SELECT USER_NAME from USER where USER_PRIV='".$USER_PRIV."' AND DEPT_ID='{$DEPT_ID}' and NOT_LOGIN='1' order by USER_NO,USER_NAME";
        $cursor1 = exequery( $connection, $query1 );
        while ( $ROW1 = mysql_fetch_array( $cursor1 ) ){
            $USER_NAME_STR3 .= $ROW1['USER_NAME'].$POSTFIX;
            $COUNT3++;
            $COUNT_DEPT["{$DEPT_ID}"][3]++;
        }
        $USER_NAME_STR1 = substr( $USER_NAME_STR1, 0, 0 - strlen( $POSTFIX ) );
        $USER_NAME_STR2 = substr( $USER_NAME_STR2, 0, 0 - strlen( $POSTFIX ) );
        $USER_NAME_STR3 = substr( $USER_NAME_STR3, 0, 0 - strlen( $POSTFIX ) );
        $OPTION_TEXT .= "\r\n  <tr class=TableData>\r\n    <td nowrap class=\"TableContent\">".$DEEP_COUNT1."├".$DEPT_NAME."</td>\r\n    <td class=\"TableContent\" align=\"center\">".( $COUNT_DEPT["{$DEPT_ID}"][1] ? $COUNT_DEPT["{$DEPT_ID}"][1] : 0 )."(".( $COUNT_DEPT["{$DEPT_ID}"][3] ? $COUNT_DEPT["{$DEPT_ID}"][3] : 0 ).")/".( $COUNT_DEPT["{$DEPT_ID}"][2] ? $COUNT_DEPT["{$DEPT_ID}"][2] : 0 )."</td>\r\n    <td style=\"cursor:hand\">".$USER_NAME_STR1."</td>\r\n    <td style=\"cursor:hand\">".$USER_NAME_STR3."</td>\r\n\t<td style=\"cursor:hand\">".$USER_NAME_STR2."</td>\r\n  </tr>";
        if ( $OPTION_TEXT_CHILD != "" ){
            $OPTION_TEXT .= $OPTION_TEXT_CHILD;
        }
    }
    $DEEP_COUNT = $DEEP_COUNT1;
    return $OPTION_TEXT;
}

require( "../../../include/auth.php" );
require( "../../../include/tools.php" );
$USER_PRIV = $_GET['USER_PRIV'];
$query = "SELECT PRIV_NAME from USER_PRIV where USER_PRIV='".$USER_PRIV."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) ){
    $PRIV_NAME = $ROW['PRIV_NAME'];
}

$COUNT1 = $COUNT2 = $COUNT3 = 0;
$OPTION_TEXT = dept_tree_list( 0 );
$COUNT11 = $COUNT21 = $COUNT31 = 0;
$query1 = "SELECT USER_NAME from USER where USER_PRIV='".$USER_PRIV."' AND DEPT_ID='0'  order by USER_NO,USER_NAME";
$cursor1 = exequery( $connection, $query1 );
while ( $ROW1 = mysql_fetch_array( $cursor1 ) ){
    $USER_NAME_STR11 .= $ROW1['USER_NAME'].$POSTFIX;
    $COUNT11++;
}
$query1 = "SELECT USER_NAME from USER where FIND_IN_SET(".$USER_PRIV.",USER_PRIV_OTHER) AND DEPT_ID='0'  order by USER_NO,USER_NAME";
$cursor1 = exequery( $connection, $query1 );
while ( $ROW1 = mysql_fetch_array( $cursor1 ) ){
    $USER_NAME_STR21 .= $ROW1['USER_NAME'].$POSTFIX;
    $COUNT21++;
}
$query1 = "SELECT USER_NAME from USER where USER_PRIV='".$USER_PRIV."' AND DEPT_ID='0' and NOT_LOGIN='1' order by USER_NO,USER_NAME";
$cursor1 = exequery( $connection, $query1 );
while ( $ROW1 = mysql_fetch_array( $cursor1 ) ){
    $USER_NAME_STR31 .= $ROW1['USER_NAME'].$POSTFIX;
    $COUNT31++;
}
$OPTION_TEXT1 = "\r\n  <tr class=TableData>\r\n    <td nowrap class=\"TableContent\">├"._( "离职人员/外部人员" )."</td>\r\n    <td class=\"TableContent\" align=\"center\">".$COUNT11."(".$COUNT31.")/".$COUNT21."</td>\r\n    <td style=\"cursor:hand\">".$USER_NAME_STR11."</td>\r\n    <td style=\"cursor:hand\">".$USER_NAME_STR31."</td>\r\n\t<td style=\"cursor:hand\">".$USER_NAME_STR21."</td>\r\n  </tr>";
$OPTION_TEXT .= $OPTION_TEXT1;
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo _( "查看角色详情" );?>--<?php echo $PRIV_NAME;?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body class="bodycolor" topmargin="5">
    <table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">  
        <tr>    
            <td class="Big">
                <img src="<?php echo SITE_URL;?>assets/images/folder.gif" align="absmiddle">
                <span class="big3"><?php echo _( "角色详情" );?>--[<?php echo $PRIV_NAME;?>]</span>    
            </td>    
        </tr>
    </table>
    <table class="TableBlock" width="100%" align="center">    
        <tr class="TableHeader">      
            <td nowrap align="center"><?php echo _( "部门/成员单位" );?></td>      
            <td nowrap align="center"><?php echo _( "人数统计" );?></td>      
            <td nowrap align="center"><?php echo _( "主角色总用户" );?></td>      
            <td nowrap align="center"><?php echo _( "(禁止登陆用户)" );?></td>      
            <td nowrap align="center"><?php echo _( "辅助角色用户" );?></td>    
        </tr>
        <?php echo $OPTION_TEXT;?>
        <tfoot class="TableControl">      
        <td nowrap align="center"><b><?php echo _( "合计：" );?></b></td>      
        <td></td>      
        <td nowrap align="center"><b><?php echo $COUNT1 + $COUNT11;?></b></td>      
        <td nowrap align="center"><b><?php echo $COUNT3 + $COUNT31;?></b></td>      
        <td nowrap align="center"><b><?php echo $COUNT2 + $COUNT21;?></b></td>    
        </tfoot>  
    </table>
</body>
</html>