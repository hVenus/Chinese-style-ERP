<?php
include_once( "inc/conn.php" );
include_once( "inc/td_core.php" );
include_once( "inc/utility.php" );
include('inc/utility_device.php');


// session 开始
session_start( );

// 用户选择系统语言之后保存语言参数。
if ( $_POST['language'] != "" ){
    setcookie( "LANG_COOKIE", $_POST['language'], time( ) + 86400000, "/" ); // 为了兼容旧版.
    setcookie( "i18n_COOKIE", $_POST['language'], time( ) + 86400000, "/" ); // 目前以这个为准。
}else{
    // 默认为中文
    setcookie( "i18n_COOKIE", 'zh_CN', time( ) + 86400000, "/" );
}
// 语言环境的session变量.
$_SESSION['locale'] = $_POST['language'];

// 把用户名写到cookie里，登录时记住用户名。
if(isset($_POST['UNAME'])&& trim($_POST['UNAME'])!=''){
    setcookie( "LOGIN_COOKIE_UNAME", $_POST['UNAME'], time( ) + 3600*24*7, "/" ); // 24*7小时后过期
}

ob_start();

echo "<html><head><title>";
echo _( "系统登录" );
echo "</title><meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"><link rel=\"stylesheet\" type=\"text/css\" href=\"/theme/9/style.css\"></head><body class=\"bodycolor\" topmargin=\"5\">";

if ( $UNAME != "" ){
    // 这里很蛋疼的把用户名统一搞成小写。
    $USERNAME = strtolower($UNAME);
}
$USERNAME = trim( $USERNAME );

// 登录验证
$LOGIN_MSG = login_check( $USERNAME, $PASSWORD, $KEY_DIGEST, $KEY_SN, $KEY_USER );

// 返回1才是登录成功
if ( $LOGIN_MSG != "1" ){
    message(
        _( "错误" ),
        $LOGIN_MSG,
        "error",
        array(
            array(
                "value" => _( "重新登录" ),
                "href" => "/"
            )
        )
    );
    if ( $USERNAME == "admin" ){
        echo "<br><div class=small1 align=center>"._("忘记了admin密码？请联系系统管理员。")."</div>";
    }
    exit( );
}

// 直接设为0
$UI = 0;
setcookie( "UI_COOKIE", $UI, time( ) + 86400000 );

echo "<script>function goto_oa(){window.location.href=\"general\";}";
echo "goto_oa();";
echo "</script><div class=big1>";
echo _( "正在进入系统，请稍候..." );
echo "</div></body></html>";


// End file logincheck.php
// Location: webroot/logincheck.php