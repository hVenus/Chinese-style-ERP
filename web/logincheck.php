<?php
// 加载数据库操作类
require("include/conn.php");
require("include/tools.php");
// 加载核心验证类
require( "include/core.php" );

// 把用户名写到cookie里，登录时记住用户名。
if(isset($_POST['UNAME'])&& trim($_POST['UNAME'])!=''){
    setcookie( "LOGIN_COOKIE_UNAME", $_POST['UNAME'], time( ) + 3600*24*7, "/" ); // 24*7小时后过期
    $USERNAME = trim($_POST['UNAME']);
    $PASSWORD = $_POST['PASSWORD'];
}

// 登录验证
$LOGIN_MSG = Login( $USERNAME, $PASSWORD );

?>
<!DOCTYPE html>
<html>
<head>
    <title>系统登录</title>
    <meta charset="utf-8">
</head>
<body class="bodycolor" topmargin="5">
    <?php  if ( $LOGIN_MSG != "1" ){?>
    <table class="MessageBox" align="center" width="500">
        <tr class="head">
           <td class="left"></td>
           <td class="center">
              <div class="title">错误</div>
           </td>
           <td class="right"></td>
        </tr>
        <tr class="msg">
           <td class="left"></td>
           <td class="center error">
              <div class="msg-content"><?php echo $LOGIN_MSG;?></div>
           </td>
           <td class="right"></td>
        </tr>
        <tr class="control">
           <td class="left"></td>
           <td class="center"><a class="BigBtn" href="./"><span>重新登录</span></a>&nbsp;&nbsp;</td>
           <td class="right"></td>
        </tr>
        <tr class="foot">
           <td class="left"></td>
           <td class="center"></td>
           <td class="right"></td>
        </tr>
    </table>
     <br>
     <div class=small1 align=center>忘记了admin密码？请联系系统管理员。</div>
    <?php }else{ ?>
<div class=big1>
正在进入系统，请稍候...
<script>
    function goto_oa(){
        window.location.href="app"; 
    }
    goto_oa();
</script>
</div>     
    <?php }?>
</body>
</html>