<?php
require( "../../../include/auth.php" );
$MENU_TOP = array(
    array(
        "text" => _( "角色管理" ),
        "href" => "manage.php",
        "target" => "",
        "title" => "",
        "img" => "/images/sys_config.gif"
    ),
    array(
        "text" => _( "新建角色" ),
        "href" => "edit.php",
        "target" => "",
        "title" => "",
        "img" => "/images/sys_config.gif"
    ),
    array(
        "text" => _( "调整角色排序" ),
        "href" => "priv_no.php",
        "target" => "",
        "title" => "",
        "img" => "/images/sys_config.gif"
    ),
    array(
        "text" => _( "添加/删除权限" ),
        "href" => "priv.php",
        "target" => "",
        "title" => "",
        "img" => "/images/sys_config.gif"
    ),
    array(
        "text" => _( "添加/删除辅助角色" ),
        "href" => "other_priv.php",
        "target" => "",
        "title" => "",
        "img" => "/images/sys_config.gif"
    )
);
include_once( "../../../include/menu_top.php" );
?>
