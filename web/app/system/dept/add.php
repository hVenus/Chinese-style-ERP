<?php
require( "../../../include/auth.php" );
//include_once( "inc/utility_all.php" );
//include_once( "inc/utility_org.php" );
$PARA_ARRAY = get_sys_para( "LOGIN_USE_DOMAIN" );
while ( list( $PARA_NAME, $PARA_VALUE ) = each( $PARA_ARRAY ) ){
    $$PARA_NAME = $PARA_VALUE;
}
$DEPT_PARENT = $_POST['DEPT_PARENT'];
?>
<html>
<head>
    <title><?php echo _( "增加部门" );?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="/css/oa.css" rel="stylesheet" type="text/css">
</head>
<body class="bodycolor" topmargin="5">
<?php
if ( trim( $_POST['DEPT_NAME'] ) == "" ){
    message( _( "错误" ), _( "部门名称不能为空" ) );
    button_back_new( );
    exit( );
}
if ( strstr( $_POST['DEPT_NAME'], "\\" ) ){
    message( _( "错误" ), _( "部门名称中含有\\" ) );
    button_back_new( );
    exit( );
}
$DEPT_NAME = str_replace( array( "\\\"", "\\'" ), array( "", "" ), $_POST['DEPT_NAME'] );

if ( !preg_match( "/[0-9]{3}$/", $_POST['DEPT_NO'] ) ){
    message( _( "错误" ), _( "排序号长度必须为3位，且都是数字" ) );
    button_back_new( );
    exit( );
}

// 是否分支机构
$IS_ORG = 0;
if($LOGIN_USER_PRIV == "1" && isset($_POST['IS_ORG']) && $_POST['IS_ORG'] == "on"){
    $IS_ORG = 1;
}else{
    $IS_ORG = 0;
}
//$IS_ORG = $LOGIN_USER_PRIV == "1" && $IS_ORG == "on" ? "1" : "0";

if($IS_ORG==1){
    // 查询排序号.分支机构要查左边开始三位是否相同
    $query = "SELECT DEPT_ID from DEPARTMENT where DEPT_PARENT='".$DEPT_PARENT."' and left(DEPT_NO,3)='{$_POST['DEPT_NO']}' and DEPT_ID!='{$DEPT_ID}'";
    $cursor = exequery( $connection, $query );
    if ( 0 < mysql_num_rows( $cursor ) ){
        message( _( "错误" ), _( "排序号 ".$DEPT_NO." 已被使用" ) );
        button_back_new( );
        exit( );
    }

    $query = "insert into DEPARTMENT(DEPT_NAME,TEL_NO,FAX_NO,DEPT_ADDRESS,DEPT_NO,MANAGER,ASSISTANT_ID,LEADER1,LEADER2,DEPT_FUNC,IS_ORG,DEPT_PARENT) values ('".$DEPT_NAME."','{$TEL_NO}','{$FAX_NO}','{$DEPT_ADDRESS}','{$DEPT_NO}','{$TO_ID}','{$ASSISTANT_ID}','{$TO_ID3}','{$TO_ID4}','{$DEPT_FUNC}','{$IS_ORG}',0)";
}

if($IS_ORG==0){
    // 查询排序号.非分支机构要查右边开始三位是否相同。
    $query = "SELECT DEPT_ID from DEPARTMENT where DEPT_PARENT='".$DEPT_PARENT."' and right(DEPT_NO,3)='{$_POST['DEPT_NO']}' and DEPT_ID!='{$DEPT_ID}'";
    $cursor = exequery( $connection, $query );
    if ( 0 < mysql_num_rows( $cursor ) ){
        message( _( "错误" ), _( "排序号 ".$DEPT_NO." 已被使用" ) );
        button_back_new( );
        exit( );
    }

    // 查父ID. 非分支机构才要拼DEPT_NO字符串。
    $query = "SELECT DEPT_NO from DEPARTMENT where DEPT_ID ='".$DEPT_PARENT."'";
    $cursor = exequery( $connection, $query );
    if ( $ROW = mysql_fetch_array( $cursor ) ){
        $PARENT_DEPT_NO = $ROW['DEPT_NO'];
    }
    $DEPT_NO = $PARENT_DEPT_NO.$DEPT_NO;

    $query = "insert into DEPARTMENT(DEPT_NAME,TEL_NO,FAX_NO,DEPT_ADDRESS,DEPT_NO,MANAGER,ASSISTANT_ID,LEADER1,LEADER2,DEPT_FUNC,IS_ORG,DEPT_PARENT) values ('".$DEPT_NAME."','{$TEL_NO}','{$FAX_NO}','{$DEPT_ADDRESS}','{$DEPT_NO}','{$TO_ID}','{$ASSISTANT_ID}','{$TO_ID3}','{$TO_ID4}','{$DEPT_FUNC}','{$IS_ORG}','{$DEPT_PARENT}')";
}

exequery( $connection, $query );
$DEPT_ID = mysql_insert_id( );
set_sys_para( array( "ORG_UPDATE" => date( "Y-m-d H:i:s" ) ) );
add_log( 3, $DEPT_ID, $LOGIN_USER_ID );
cache_department( );
?>
<script>
    parent.dept_list.location.reload();
    location="dept_new.php?DEPT_ID=<?php echo $DEPT_PARENT;?>";
</script>
</body>
</html>