<?php
function tree_delete( $DEPT_ID )
{
    global $connection;
    global $LOGIN_USE_DOMAIN;
    $query = "delete from DEPARTMENT where DEPT_ID='".$DEPT_ID."'";
    exequery( $connection, $query );
    if ( $LOGIN_USE_DOMAIN == "1" ){
        $query = "delete from DEPT_MAP where DEPT_ID='".$DEPT_ID."'";
        exequery( $connection, $query );
    }
    $query = "select * from USER where DEPT_ID='".$DEPT_ID."' and USER_ID='admin'";
    $cursor = exequery( $connection, $query );
    if ( $ROW = mysql_fetch_array( $cursor ) ){
        $query = "update USER set DEPT_ID=0 where USER_ID='admin'";
        exequery( $connection, $query );
    }
    $query = "delete from USER where DEPT_ID='".$DEPT_ID."'";
    exequery( $connection, $query );
    $query = "select * from DEPARTMENT where DEPT_PARENT='".$DEPT_ID."'";
    $cursor = exequery( $connection, $query );
    while ( $ROW = mysql_fetch_array( $cursor ) ){
        $DEPT_ID = $ROW['DEPT_ID'];
        tree_delete( $DEPT_ID );
    }
}

require( "../../../include/auth.php" );
//include_once( "inc/utility_all.php" );
//include_once( "inc/utility_org.php" );
$PARA_ARRAY = get_sys_para( "LOGIN_USE_DOMAIN" );
while ( list( $PARA_NAME, $PARA_VALUE ) = each( $PARA_ARRAY ) )
{
    $$PARA_NAME = $PARA_VALUE;
}
?>
<html>
<head>
    <title><?php echo _( "删除部门" );?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="/css/oa.css" rel="stylesheet" type="text/css">
</head>
<body class="bodycolor" topmargin="5">
<?php
add_log( 5, $DEPT_ID, $LOGIN_USER_ID );
tree_delete( $DEPT_ID );
set_sys_para( array( "ORG_UPDATE" => date( "Y-m-d H:i:s" ) ) );
cache_department( );
message( _( "提示" ), _( "部门/成员单位已删除" ) );
?>
<script>parent.dept_list.location.reload();</script>
</body>
</html>