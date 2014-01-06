<?php
require( "../../include/core.php" );
require( "../../../include/auth.php" );
//include_once( "inc/utility_all.php" );
//include_once( "inc/utility_org.php" );
$PARA_ARRAY = get_sys_para( "LOGIN_USE_DOMAIN" );
while ( list( $PARA_NAME, $PARA_VALUE ) = each( $PARA_ARRAY ) ){
    $$PARA_NAME = $PARA_VALUE;
}
?>
<html>
<head>
    <title><?php echo _( "修改部门" );?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="/css/oa.css" rel="stylesheet" type="text/css">
</head>
<body class="bodycolor" topmargin="5">
<?php
// 是否分支机构
$IS_ORG = 0;
if($LOGIN_USER_PRIV == "1" && isset($_POST['IS_ORG']) && $_POST['IS_ORG'] == "on"){
    $IS_ORG = 1;
}else{
    $IS_ORG = 0;
}
//$IS_ORG = $LOGIN_USER_PRIV == "1" && $IS_ORG == "on" ? "1" : "0";

// 是否停用
$IS_STOP = 0;
if($LOGIN_USER_PRIV == "1" && isset($_POST['IS_STOP']) && $_POST['IS_STOP'] == "on"){
    $IS_STOP = 1;
}else{
    $IS_STOP = 0;
}
//$IS_STOP = $LOGIN_USER_PRIV == "1" && $IS_STOP == "on" ? "1" : "0";

if ( strstr( $DEPT_NAME, "\\" ) ){
    message( _( "错误" ), _( "部门名称中含有\\" ) );
    button_back_new( );
    exit( );
}
$DEPT_NAME = str_replace( array( "\\\"", "\\'" ), array( "", "" ), $DEPT_NAME );

if ( !preg_match( "/[0-9]{3}$/", $DEPT_NO ) ){
    message( _( "错误" ), _( "排序号长度必须为3位，且都是数字" ) );
    button_back_new( );
    exit( );
}

if($IS_ORG==1){
    $query = "SELECT DEPT_ID from DEPARTMENT where DEPT_PARENT='".$DEPT_PARENT."' and left(DEPT_NO,3)='{$DEPT_NO}' and DEPT_ID!='{$DEPT_ID}'";
    $cursor = exequery( $connection, $query );
    if ( 0 < mysql_num_rows( $cursor ) ){
        message( _( "错误" ), _( "排序号 ".$DEPT_NO." 已被使用" ) );
        button_back_new( );
        exit( );
    }

    // 保存
    $query = "update DEPARTMENT set DEPT_NAME='".$DEPT_NAME."',TEL_NO='{$TEL_NO}',FAX_NO='{$FAX_NO}',DEPT_ADDRESS='{$DEPT_ADDRESS}',DEPT_NO='{$DEPT_NO}',MANAGER='{$TO_ID}',ASSISTANT_ID='{$ASSISTANT_ID}',LEADER1='{$TO_ID3}',LEADER2='{$TO_ID4}',DEPT_FUNC='{$DEPT_FUNC}',IS_ORG='{$IS_ORG}', DEPT_PARENT=0 where DEPT_ID='{$DEPT_ID}'";
}
if($IS_ORG==0){
    $query = "SELECT DEPT_ID from DEPARTMENT where DEPT_PARENT='".$DEPT_PARENT."' and right(DEPT_NO,3)='{$DEPT_NO}' and DEPT_ID!='{$DEPT_ID}'";
    $cursor = exequery( $connection, $query );
    if ( 0 < mysql_num_rows( $cursor ) ){
        message( _( "错误" ), _( "排序号 ".$DEPT_NO." 已被使用" ) );
        button_back_new( );
        exit( );
    }

    $DEPT_PARENT_NO = "";
    if ( $DEPT_PARENT != 0 ){
        $query = "SELECT DEPT_NO from DEPARTMENT where DEPT_ID='".$DEPT_PARENT."'";
        $cursor = exequery( $connection, $query );
        if ( $ROW = mysql_fetch_array( $cursor ) ){
            $DEPT_PARENT_NO = $ROW['DEPT_NO'];
        }
    }
    $DEPT_NO = $DEPT_PARENT_NO.$DEPT_NO;

    // 保存
    $query = "update DEPARTMENT set DEPT_NAME='".$DEPT_NAME."',TEL_NO='{$TEL_NO}',FAX_NO='{$FAX_NO}',DEPT_ADDRESS='{$DEPT_ADDRESS}',DEPT_NO='{$DEPT_NO}',MANAGER='{$TO_ID}',ASSISTANT_ID='{$ASSISTANT_ID}',LEADER1='{$TO_ID3}',LEADER2='{$TO_ID4}',DEPT_FUNC='{$DEPT_FUNC}',IS_ORG='{$IS_ORG}', DEPT_PARENT='{$DEPT_PARENT}' where DEPT_ID='{$DEPT_ID}'";
}

exequery( $connection, $query );

// 设置更新时间
$query = "select * from DEPARTMENT where DEPT_ID='".$DEPT_ID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) ){
    $DEPT_NO_OLD = $ROW['DEPT_NO'];
    $DEPT_NAME_OLD = $ROW['DEPT_NAME'];
    $DEPT_PARENT_OLD = $ROW['DEPT_PARENT'];
    if ( $DEPT_NO_OLD != $DEPT_NO || $DEPT_NAME_OLD != $DEPT_NAME || $DEPT_PARENT_OLD != $DEPT_PARENT ){
        set_sys_para( array( "ORG_UPDATE" => date( "Y-m-d H:i:s" ) ) );
    }
}

add_log( 4, $DEPT_ID, $LOGIN_USER_ID );
message( _( "提示" ), _( "部门/成员单位信息已保存修改" ) );
cache_department( );
button_back_new( );
?>
<script>parent.dept_list.location.reload();</script>
</body>
</html>