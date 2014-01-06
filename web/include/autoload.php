<?php
/**
 * 自动加载方法
 * ·class
 * ·funciton
 *
 * 所有的公共类库放在webroot/libary目录下。
 * 统一为: libary/NAME/NAME.php
 * libary下建目录与类同名，
 * 目录下再建php文件，与类同名。
 *
 * 若需要放在多层目录下，则类命名用下划线来区分目录。
 * 例如：class core_db_pdo{}
 * 存放的目录应该为 libary/core/db/pdo.php
 * new core_db_pdo()的时候会自动加载libary/core/db/pdo.php文件。
 *
 * 先查找webroot/libary目录。
 * 其它目录如有必要以后再加。
 */


/**
 * autoload method
 * @param $class
 */
function loader($class){
    $file = LIBRARY_PATH;

    // 按"_"把类名分隔到数据里.
//    $arr = explode("_", trim($class, "_"));
//    $num = count($arr);
//    // 数据个数大于1,说明有多层目录.
//    if(count($arr)>1){
//        for($i=0; $i<($num-1); $i++){
//            $file .= $arr[$i].DS;
//        }
//        $file .= $class.'.php';
//    }else{
//        $file .= $class.'.php';
//    }
    // WEB-INF/classes下就不分目录了。
    $file = $file.$class.'.php';
    if(is_file($file)){
        require($file);
    }else{
        die("Can not found class ".$class." in ".$file);
    }
}
// 注册autoload register function
spl_autoload_register('loader');

// 设置类库存放的目录
ini_set('include_path', 'WEB-INF/classes');