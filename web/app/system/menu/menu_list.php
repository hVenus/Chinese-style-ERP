<?php
include_once( "../../../include/auth.php" );
$SCRIPT = "function delete_menu(MENU_ID,MENU_NAME){ var msg = sprintf(\""._( "确认要删除主菜单分类 '%s' 吗？下级子菜单也将被删除" )."\", MENU_NAME); if(window.confirm(msg)) {    URL=\"delete.php?MENU_ID=\" + MENU_ID;    parent.menu_edit.location=URL; }}";
$MENU_HEAD = array( "text" => _( "菜单主分类设置" ), "img" => SITE_URL."assets/images/menu/system.gif", "class" => "" );
$module = "<table class=\"TableBlock\" width=\"95%\" align=\"center\">";
$query = "SELECT * from SYS_MENU order by MENU_ID";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
    $MENU_ID = $ROW['MENU_ID'];
    $MENU_NAME = $ROW['MENU_NAME'];
    $FUNC_ID_STR = $ROW['FUNC_ID_STR'];
    $IMAGE = $ROW['IMAGE'];
    $MENU_EXT = unserialize( $ROW['MENU_EXT'] );
    if ( is_array( $MENU_EXT ) && $MENU_EXT[$LANG_COOKIE] != "" )
    {
        $MENU_NAME = $MENU_EXT[$LANG_COOKIE];
    }
    $module .= '<tr class="TableData" title="'.$MENU_NAME.'">'
            . '<td>'
            . '<img src="'.SITE_URL.'assets/images/menu/'.$IMAGE.'.gif" width="16" height="16">&nbsp;'.$MENU_ID.'&nbsp;<b>'.$MENU_NAME.'</b>     '
            . '</td>'
            . '<td nowrap align="center">       '
            . '<a href="edit.php?MENU_ID='.$MENU_ID.'" target="menu_edit">'._( "编辑" ).'</a>&nbsp;'
            . '<a href="func?MENU_ID='.$MENU_ID."\" target=\"menu_edit\"> "._( "下一级" )."</a>&nbsp;"
            . "<a href=\"javascript:delete_menu('".$MENU_ID."','".$MENU_NAME."');\"> "._( "删除" )."</a>"
            . "</td>"
            . "</tr>";
}
$module .= "</table>";
$MENU_LEFT = array( );
$target = "menu_edit";
$MENU_LEFT[count( $MENU_LEFT )] = array( 
    "text" => _( "增加菜单主分类" ), 
    "href" => "new.php", 
    "onclick" => "", 
    "target" => $target, 
    "title" => "", 
    "img" => "", 
    "module" => $module, 
    "module_style" => "" 
    );
include_once( "../../../include/menu_left.php" );
