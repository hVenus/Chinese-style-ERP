<?php
// 数据库连接
require("conn.php");
require("session.php");
require("tools.php");
if ( stristr( $PHP_SELF, "export" ) || stristr( $PHP_SELF, "excel" ) || stristr( $PHP_SELF, "word" ) || stristr( $PHP_SELF, "attach.php" ) || stristr( $PHP_SELF, "download.php" ) || stristr( $PHP_SELF, "down.php" ) ){
    session_cache_limiter( "private, must-revalidate" );
}
session_start( );

// 菜单项的缓存
require( "sys_function.php" );


// 判断用户是否登录
if ( (!isset($_SESSION["LOGIN_USER_ID"]) && $_SESSION["LOGIN_USER_ID"] == "") || (!isset( $_SESSION["LOGIN_UID"] ) && $_SESSION["LOGIN_UID"] == "") ){
    echo "<html><head>";
    echo "<title>"._( "用户未登录" )."</title>";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
    echo "<script>var d=new Date();var h=Math.abs(parseInt((d.getTime()/1000-".time( ).")/3600));if(h>=1) alert(\""._( "客户端和服务器时间相差超过1个小时，请检查客户端和服务器的日期和时间是否正确" )."\");</script>";
    echo "</head><body class=\"bodycolor\">";
    message( _( "警告" ), _( "用户未登录，请重新登录!" ) );
    echo "<center><br><input type=\"button\" value=\""._( "重新登录" )."\" class=\"BigButton\" onclick=\"window.top.location='../';\"></center>";
    echo "</body></html>";
    exit( );
}


// 获取用户角色
if ( !isset( $_SESSION["LOGIN_USER_PRIV"] ) ) {
    $query = "select USER_PRIV from USER where UID='".$_SESSION["LOGIN_UID"]."' ";
    $cursor = exequery( $connection, $query );
    if ( $ROW = mysql_fetch_array( $cursor ) ) {
        $LOGIN_USER_PRIV = $ROW['USER_PRIV'];
        $_SESSION["LOGIN_USER_PRIV"] = $LOGIN_USER_PRIV;
    }
}

// 用户的菜单.有权限的都在这里了。
$USER_FUNC_ID_STR = $LOGIN_FUNC_STR;
if ( $LOGIN_USER_ID == "admin" ) {
    $USER_FUNC_ID_STR .= "32,33,56,";
}
$USER_FUNC_ID_STR = trim( $USER_FUNC_ID_STR, "," );
$SAFE_CHECK_OK = 0;

// 判断是否访问general目录内的程序
if ( stristr( $SCRIPT_NAME, "/app" ) ) {
    // 把general去掉，只留有用的部分。这部分就是菜单设置里填的程序的路径。
    $SCRIPT_NAME = substr( $SCRIPT_NAME, 9 );
    $SCRIPT_NAME = ltrim( $SCRIPT_NAME, "/" );

    // 这是判断什么？
    // 把路径拆开来。
    if ( stristr( $SCRIPT_NAME, "/" ) ) {
        $SCRIPT_NAME1 = substr( $SCRIPT_NAME, 0, strpos( $SCRIPT_NAME, "/" ) );//var_dump($SCRIPT_NAME1);
        $SCRIPT_NAME2 = substr( $SCRIPT_NAME, 0, strpos( $SCRIPT_NAME, "/", strlen( $SCRIPT_NAME1 ) + 1 ) );//var_dump($SCRIPT_NAME2);
        $SCRIPT_NAME3 = substr( $SCRIPT_NAME, 0, strrpos( $SCRIPT_NAME, "/" ) );//var_dump($SCRIPT_NAME3);
    }

    // 都是界面上的公共部分
    if ( $SCRIPT_NAME1 == "" || $SCRIPT_NAME1 == "status_bar" || $SCRIPT_NAME1 == "ipanel" || $SCRIPT_NAME1 == "portal" || $SCRIPT_NAME1 == "ilook" || $SCRIPT_NAME1 == "winexe" || $SCRIPT_NAME1 == "mytable" || stristr( $SCRIPT_NAME, "news/show" ) || stristr( $SCRIPT_NAME, "vote/show" ) || $SCRIPT_NAME1 == "crm" ){
        $SAFE_CHECK_OK = 1;
    }else{
        // file_folder,netdisk,picture,im默认所有人都有访问权限 ？
        if ( $SCRIPT_NAME1 == "file_folder" || $SCRIPT_NAME1 == "netdisk" || $SCRIPT_NAME1 == "picture" || $SCRIPT_NAME1 == "im" ){
            $SAFE_CHECK_OK = 1;
        }else{
            // 工作流都有权限 ？
            if ( $SCRIPT_NAME1 == "workflow" ){
                $SAFE_CHECK_OK = 1;
            }else{
                // 在这里判断其它程序是否有权限。我猜的。
                // 遍历菜单项
                while ( list( $FUNC_ID, $FUNC_CODE ) = each($SYS_FUNCTION) ){
                    // 找出有权限的菜单项
                    if ( find_id( $USER_FUNC_ID_STR, $FUNC_ID ) ){
                        // 比较一下程序路径，是否相同.
                        if(substr( $SCRIPT_NAME, 0, strlen( $FUNC_CODE ) ) == $FUNC_CODE){
                            // 置为1，退出循环。
                            $SAFE_CHECK_OK = 1;
                            break;
                        }
                    }
                }
            }
        }
        //$SAFE_CHECK_OK = 1;
    }
}
else {
    $SAFE_CHECK_OK = 1;
}

// 显示无权限访问提示
if ( $SAFE_CHECK_OK == 0 ){
    echo "<html><head><title>"._( "目录访问限制" )."</title>";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
    echo "</head><body class='bodycolor'><body class=\"bodycolor\">";
    message( _( "警告" ), _( "无该模块使用权限！如需使用该模块，请联系管理员重新设置本角色权限！" ) );
    echo "</body></html>";
    exit( );
}

// ccorrect_btn.js
if ( $CORRECT_BUTTON ){
    //echo "<script src=\"/inc/js/ccorrect_btn.js\"></script>\r\n";
}

// End File: auth.php
// Location: webroot/inc/auth.php