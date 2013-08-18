<?php
include_once( "inc/auth.php" );
include_once( "inc/utility_all.php" );
echo "\r\n<html>\r\n<head>\r\n<title>修改密码</title>\r\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\r\n</head>\r\n<body class=\"bodycolor\" topmargin=\"5\">\r\n\r\n";
if ( $MYOA_IS_DEMO )
{
    message( "提示", "演示版不能修改密码" );
    button_back_new( );
    exit( );
}
$query = "SELECT * from SYS_PARA where PARA_NAME='SEC_PASS_MIN' or PARA_NAME='SEC_PASS_MAX' or PARA_NAME='SEC_PASS_SAFE'";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
    $PARA_NAME = $ROW['PARA_NAME'];
    $PARA_VALUE = $ROW['PARA_VALUE'];
    if ( $PARA_NAME == "SEC_PASS_MIN" )
    {
        $SEC_PASS_MIN = $PARA_VALUE;
    }
    else if ( $PARA_NAME == "SEC_PASS_MAX" )
    {
        $SEC_PASS_MAX = $PARA_VALUE;
    }
    else if ( $PARA_NAME == "SEC_PASS_SAFE" )
    {
        $SEC_PASS_SAFE = $PARA_VALUE;
    }
}
if ( strlen( $PASS1 ) < $SEC_PASS_MIN || strlen( $PASS2 ) < $SEC_PASS_MIN || $SEC_PASS_MAX < strlen( $PASS1 ) || $SEC_PASS_MAX < strlen( $PASS2 ) )
{
    message( "错误", "密码长度应".$SEC_PASS_MIN."-".$SEC_PASS_MAX."位!" );
    button_back_new( );
    exit( );
}
if ( $PASS1 != $PASS2 )
{
    message( "错误", "输入的新密码不一致！" );
    button_back_new( );
    exit( );
}
if ( strstr( $PASS1, "\\'" ) )
{
    message( "错误", "新密码中含有非法字符" );
    button_back_new( );
    exit( );
}
if ( $PASS1 == $PASS0 )
{
    message( "错误", "新密码不能与原密码相同！" );
    button_back_new( );
    exit( );
}
if ( $SEC_PASS_SAFE == "1" && ( !eregi( "[a-z]", $PASS1 ) || !eregi( "[0-9]", $PASS1 ) ) )
{
    message( "错误", "密码必须同时包含字母和数字!" );
    button_back_new( );
    exit( );
}
$query = "SELECT PASSWORD,USEING_KEY from USER where USER_ID='".$LOGIN_USER_ID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
    $PASSWORD = $ROW['PASSWORD'];
    $USEING_KEY = $ROW['USEING_KEY'];
    if ( crypt( $PASS0, $PASSWORD ) != $PASSWORD )
    {
        message( "错误", "输入的原密码错误!" );
        button_back_new( );
        exit( );
    }
}
$PASS1 = crypt( $PASS1 );
$CUR_TIME = date( "Y-m-d H:i:s", time( ) );
$query = "update USER SET PASSWORD='".$PASS1."',LAST_PASS_TIME='{$CUR_TIME}' where USER_ID='{$LOGIN_USER_ID}'";
exequery( $connection, $query );
if ( $USEING_KEY == "1" )
{
    message( "提示", "用户密码已修改,请插入USB用户KEY,并重新初始化KEY" );
}
else
{
    message( "提示", "用户密码已修改!" );
}
add_log( 14, "", $LOGIN_USER_ID );
if ( $USEING_KEY == "1" )
{
    echo "   <br>\r\n   <div align=\"center\">\r\n    <input type=\"button\" value=\"初始化USB KEY\" class=\"BigButton\" onClick=\"location='create_key.php'\">\r\n   </div>\r\n";
    exit( );
}
echo "\r\n<div align=\"center\">\r\n <input type=\"button\" value=\"返回\" class=\"BigButton\" onClick=\"location='index.php'\">\r\n</div>\r\n\r\n</body>\r\n</html>\r\n";
?>
