<?php
require( "../../../include/auth.php" );
//include_once( "inc/utility_all.php" );
$MENU_LEFT = array( );
$target = "user_main";
$user_list = array(
    "PARA_URL1" => "/general/system/user/user_new.php",
    "PARA_URL2" => "/general/system/user/user_edit.php",
    "PARA_TARGET" => $target,
    "PRIV_NO_FLAG" => "3",
    "MANAGE_FLAG" => "1",
    "xname" => "system_user",
    "showButton" => "0",
    "include_file" => "inc/user_list/index.php"
);
$MENU_LEFT[count( $MENU_LEFT )] = array(
    "text" => _( "在职人员" ),
    "href" => "",
    "onclick" => "clickMenu",
    "target" => $target,
    "title" => _( "点击伸缩列表" ),
    "img" => "",
    "module" => $user_list,
    "module_style" => ""
);
$LOGIN_USER_ID = $_SESSION['LOGIN_USER_ID'];
$query = "SELECT * from USER where USER_ID='".$LOGIN_USER_ID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) )
{
    $POST_PRIV = $ROW['POST_PRIV'];
}
if ( $POST_PRIV == "1" )
{
    $MENU_LEFT[count( $MENU_LEFT )] = array(
        "text" => _( "离职人员/外部人员" ),
        "href" => "user_new.php?DEPT_ID=0",
        "onclick" => "clickMenu",
        "target" => $target,
        "title" => "",
        "img" => "",
        "module" => "",
        "module_style" => ""
    );
}
$MENU_LEFT[count( $MENU_LEFT )] = array(
    "text" => _( "最近新增用户" ),
    "href" => "user_add_last.php",
    "onclick" => "clickMenu",
    "target" => $target,
    "title" => "",
    "img" => "",
    "module" => "",
    "module_style" => ""
);
$MENU_LEFT[count( $MENU_LEFT )] = array(
    "text" => _( "用户查询或导出" ),
    "href" => "query.php",
    "onclick" => "",
    "target" => $target,
    "title" => "",
    "img" => "",
    "module" => "",
    "module_style" => ""
);
if ( $LOGIN_USER_PRIV == "1" )
{
    $MENU_LEFT[count( $MENU_LEFT )] = array(
        "text" => _( "导出RTX格式" ),
        "href" => "exp_rtx.php",
        "onclick" => "",
        "target" => $target,
        "title" => _( "导出用于在RTX导入用户和部门的XML文件" ),
        "img" => "",
        "module" => "",
        "module_style" => ""
    );
}
require( "../../../include/menu_left.php" );


// file end
