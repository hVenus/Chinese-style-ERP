<?php
/**
 * 权限相关的函数
 */

/**
 * 取第一级菜单
 */
function getMainMenuLevel1($login_user_id){
    global $connection;
    $LOGIN_USER_ID = $login_user_id;

    // 取主副角色的权限数据
    $query = "SELECT USER_PRIV, USER_PRIV_OTHER from USER where USER_ID='".$LOGIN_USER_ID."'";
    $cursor = exequery( $connection, $query );
    if ( $ROW = mysql_fetch_array( $cursor ) ){
        $USER_PRIV = $ROW['USER_PRIV'];
        $USER_PRIV_OTHER = $ROW['USER_PRIV_OTHER'];
    }

    // 取权限对应的菜单项
    $query = "SELECT func_id_str  from USER_PRIV where USER_PRIV in (".trim($USER_PRIV.','.trim($USER_PRIV_OTHER,','),',').") ";
    $cursor = exequery( $connection, $query );
    $user_priv = array();
    while ( $ROW = mysql_fetch_array( $cursor ) ){
        $user_priv[] = $ROW['func_id_str'];
    }

    // 将多个权限的菜单项合并成一个数组
    $priv = array();
    foreach($user_priv as $p){
        $temp_priv = explode(',',trim($p, ','));
        $temp = array();
        foreach($temp_priv as $t){
            $temp['_'.(string)$t.'_'] = $t;
        }
        $priv = array_merge($priv, $temp);
    }

    $priv_str = '';
    foreach($priv as $v){
        $priv_str .= $v.',';
    }

    // 获取菜单项对应的最顶层菜单项,去掉重复值，即为顶层菜单项。 取出所有有权限的记录。不用区分是第几级，因为最后只取前两位。
    $query = "SELECT distinct left(MENU_ID, 2) as menu  from sys_function where FUNC_ID in (".trim($priv_str, ',').")     ORDER BY MENU_ID ASC";
    $cursor = exequery( $connection, $query );
    $priv_array = array();
    while ( $ROW = mysql_fetch_array( $cursor) )
    {
        $priv_array[] = $ROW['menu'];
    }

    // 获取顶层菜单项的信息
    $query = 'SELECT * FROM sys_menu where 1 ORDER BY MENU_ID';
    $cursor = exequery( $connection, $query );
    $menu_l1 = array();
    while($ROW = mysql_fetch_array( $cursor ) ){
        if(in_array($ROW['MENU_ID'], $priv_array)){
            $menu_l1[$ROW['MENU_ID']] = $ROW;
        }
    }

    // 返回最终的菜单项
    return $menu_l1;
}


/**
 * 取第二级菜单
 * @param $menu_id 第一级菜单的ID
 * @return array 
 */
function getMainMenuLevel2($menu_id, $login_user_id){
    global $connection;
    $LOGIN_USER_ID = $login_user_id;

    // 取主副角色的权限数据
    $query = "SELECT USER_PRIV, USER_PRIV_OTHER from USER where USER_ID='".$LOGIN_USER_ID."'";
    $cursor = exequery( $connection, $query );
    if ( $ROW = mysql_fetch_array( $cursor ) )
    {
        $USER_PRIV = $ROW['USER_PRIV'];
        $USER_PRIV_OTHER = $ROW['USER_PRIV_OTHER'];
    }

    // 取权限对应的菜单项
    $query = "SELECT func_id_str  from USER_PRIV where USER_PRIV in (".trim($USER_PRIV.','.trim($USER_PRIV_OTHER,','),',').") ";
    $cursor = exequery( $connection, $query );
    $user_priv = array();
    while ( $ROW = mysql_fetch_array( $cursor ) )
    {
        $user_priv[] = $ROW['func_id_str'];
    }

    // 将多个权限的菜单项合并成一个数组
    $priv = array();
    foreach($user_priv as $p){
        $temp_priv = explode(',',trim($p, ','));
        $temp = array();
        foreach($temp_priv as $t){
            $temp['_'.(string)$t.'_'] = $t;
        }
        $priv = array_merge($priv, $temp);
    }

    $priv_str = '';
    foreach($priv as $v){
        $priv_str .= $v.',';
    }

    // 获取菜单项对应的第二层菜单项,去掉重复值。 只取前四位.
    $query = "SELECT distinct left(MENU_ID, 4) as menu  from sys_function where FUNC_ID in (".trim($priv_str, ',').")    ORDER BY MENU_ID ASC";
    $cursor = exequery( $connection, $query );
    $priv_array_l2 = array();
    while ( $ROW = mysql_fetch_array( $cursor) )
    {
        $priv_array_l2[] = $ROW['menu'];
    }

    // 取所有MENU_ID为4位的菜单项
    $query = "SELECT *  from sys_function where length(MENU_ID)=4 AND MENU_ID LIKE '".$menu_id."%'  ORDER BY MENU_ID ASC";
    $cursor = exequery( $connection, $query );
    $priv_array = array();
    while ( $ROW = mysql_fetch_array( $cursor) )
    {
        // 判断是否有权限
        if(in_array($ROW['MENU_ID'], $priv_array_l2)){
            $priv_array[$ROW['FUNC_ID']] = $ROW;
            if('@'==substr($ROW['FUNC_CODE'], 0, 1)){
                $priv_array[$ROW['FUNC_ID']]['parent'] = true;
            }else{
                $priv_array[$ROW['FUNC_ID']]['parent'] = false;
            }
        }
    }

    // 返回最终的菜单项
    return $priv_array;
}


/**
 * 取第三级菜单
 * @param $menu_id 第二级菜单的ID
 * @return array 
 */
function getMainMenuLevel3($menu_id, $login_user_id){
    global $connection;
    $LOGIN_USER_ID = $login_user_id;

    // 取主副角色的权限数据
    $query = "SELECT USER_PRIV, USER_PRIV_OTHER from USER where USER_ID='".$LOGIN_USER_ID."'";
    $cursor = exequery( $connection, $query );
    if ( $ROW = mysql_fetch_array( $cursor ) )
    {
        $USER_PRIV = $ROW['USER_PRIV'];
        $USER_PRIV_OTHER = $ROW['USER_PRIV_OTHER'];
    }

    // 取权限对应的菜单项
    $query = "SELECT func_id_str  from USER_PRIV where USER_PRIV in (".trim($USER_PRIV.','.trim($USER_PRIV_OTHER,','),',').") ";
    $cursor = exequery( $connection, $query );
    $user_priv = array();
    while ( $ROW = mysql_fetch_array( $cursor ) )
    {
        $user_priv[] = $ROW['func_id_str'];
    }

    // 将多个权限的菜单项合并成一个数组
    $priv = array();
    foreach($user_priv as $p){
        $temp_priv = explode(',',trim($p, ','));
        $temp = array();
        foreach($temp_priv as $t){
            $temp['_'.(string)$t.'_'] = $t;
        }
        $priv = array_merge($priv, $temp);
    }

    $priv_str = '';
    foreach($priv as $v){
        $priv_str .= $v.',';
    }

    // 获取菜单项对应的最顶层菜单项,去掉重复值，即为顶层菜单项。
    $query = "SELECT *  from sys_function where FUNC_ID in (".trim($priv_str, ',').") AND length(MENU_ID)=6 AND MENU_ID LIKE '".$menu_id."%'     ORDER BY MENU_ID ASC";
    $cursor = exequery( $connection, $query );
    $priv_array = array();
    while ( $ROW = mysql_fetch_array( $cursor) )
    {
        $priv_array[] = $ROW;
    }

    // 返回最终的菜单项
    return $priv_array;
}