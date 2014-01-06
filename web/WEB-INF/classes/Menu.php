<?php
/**
 * 系统菜单类
 *
 * 生成菜单，控制菜单，以及与菜单相关的方法。
 */


class Menu{

    function __construct(){
    }

    /**
     * 获取子菜单列表
     * @static
     * @param $menu 存放菜单的数组
     * @param $parentMenuId 父菜单MENU_ID
     * @return array|bool
     */
    static public function getChildMenu($menu, $parentMenuId){
        $result = array();
        //父菜单MENU_ID的长度, 2为顶级菜单，4为二级菜单，6为第三级。
        $parentMenuLength = strlen($parentMenuId);
        if(is_array($menu)){
            foreach($menu as $item){
                $item_id = $item['MENU_ID'];
                if( strlen($item_id)==($parentMenuLength+2) && substr( $item_id, 0, $parentMenuLength)==$parentMenuId){
                    $result[] = $item;
                }
            }
        }
        return $result;
    }
}

// End of file Menu.php
// Location: WEB-INF/classes/Menu.php