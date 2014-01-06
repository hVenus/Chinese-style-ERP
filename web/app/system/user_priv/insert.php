<?php
require( "../../../include/auth.php" );
?>
<html>
<head>
    <title><?php echo _( "新建角色" );?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body class="bodycolor" topmargin="5">
<?php 
$PRIV_NO = $_POST['PRIV_NO'];
$PRIV_NAME = $_POST['PRIV_NAME'];
if ( !CheckType::is_number( $PRIV_NO ) ){
    message( _( "错误" ), _( "角色序号应为数字！" ) );
    button_back_new( );
    exit( );
}
$query = "insert into USER_PRIV(PRIV_NO,PRIV_NAME) values ('".$PRIV_NO."','{$PRIV_NAME}')";
exequery( $connection, $query );
header( "location: manage.php" );
?>
</body>
</html>                                                                 