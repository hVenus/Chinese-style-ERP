<?php
include("include/conn.php");
if(isset($_SESSION['LOGIN_UID']) && $_SESSION['LOGIN_UID']>0){
    header("Location: app");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Chinese style ERP</title>
    <meta charset="utf-8">
    <link href="assets/css/login.css" type=text/css rel=stylesheet />
    <script type='text/javascript' src='assets/js/jquery.min.js'></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#UNAME').focus();
        });
    </script>
</head>
<body style="margin: 0; padding: 0;min-width: 800px;"  onload="" scroll="auto">
<div class="wrap">
            <br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
    <form name="form1" method="post" action="logincheck.php" autocomplete="off" >
            <table style="position: absolute;margin-left: 400px;">
                <tr>
                    <td class="ItemTitleFont" align="right" width="80" height="25">用户名：</td>
                    <td width="260"><input class="inputFrm" id="UNAME" name="UNAME" value="<?php echo $LOGIN_COOKIE_UNAME;?>"></td>
                </tr>
                <tr>
                    <td class="ItemTitleFont" align="right" height="25">1密码：</td>
                    <td><input class="inputFrm" type="password" name="PASSWORD"></td>
                </tr>
                <tr height=" 50">
                    <td align="middle" colspan="2"><input type="image" src="assets/images/btn.jpg" border="0"></td>
                </tr>
                <tr>
                    <td class="ItemTitleFont" style="color:red" align="center" colspan="2"></td>
                </tr>
            </table>
    </form>
</div>
</body>
</html>