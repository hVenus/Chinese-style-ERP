<?php
require( "../../../include/auth.php" );
$MENU_LEFT = array( );
$target = "dept_main";
$user_list = array(
    "PARA_URL" => "/general/system/dept/dept_edit.php",
    "PARA_TARGET" => $target,
    "PRIV_NO_FLAG" => "1",
    "xname" => "system_dept",
    "showButton" => "0",
    "include_file" => "inc/dept_list/index.php"
);
$MENU_LEFT[count( $MENU_LEFT )] = array(
    "text" => _( "部门列表" ),
    "href" => "",
    "onclick" => "clickMenu",
    "target" => $target,
    "title" => _( "点击伸缩列表" ),
    "img" => "",
    "module" => $user_list,
    "module_style" => ""
);
include_once( "inc/menu_left.php" );
?>
