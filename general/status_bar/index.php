<?php
include_once( "inc/auth.php" );

// 用户总数
$USER_TOTAL_COUNT = 1;
$query = "SELECT count(*) from USER where NOT_LOGIN='0'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) ){
    $USER_TOTAL_COUNT = $ROW[0];
}

// 是否接收提示和提示的声音
$query = "SELECT SMS_ON,CALL_SOUND from USER where USER_ID='".$LOGIN_USER_ID."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) ){
    $SMS_ON = $ROW['SMS_ON'];
    $CALL_SOUND = $ROW['CALL_SOUND'];
}

// 提示音
if ( $CALL_SOUND == "" ){
    $CALL_SOUND = "1";
}
$SOUND_URL = "/wav/1.swf";


$CHECK_SMS = 0;
if ( find_id( $USER_FUNC_ID_STR, "42" ) ){
    $CHECK_SMS = 1;
}else{
    $query = "select * from SMS2_PRIV";
    $cursor = exequery( $connection, $query );
    if ( $ROW = mysql_fetch_array( $cursor ) ){
        $SMS2_REMIND_PRIV = $ROW['SMS2_REMIND_PRIV'];
    }
    if ( find_id( $SMS2_REMIND_PRIV, $LOGIN_USER_ID ) ){
        $CHECK_SMS = 1;
    }
}
$NEW_SMS_HTML = "<a href='#' onclick='javascript:show_sms();' title='"._( "点击查看新消息" )."'><img src='/images/sms1.gif'border=0 height=10> "._( "新消息" )."</a>";
if ( $CALL_SOUND != "0" ){
    $NEW_SMS_SOUND_HTML = "<object id='sms_sound' classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='/inc/swflash.cab' width='0' height='0'><param name='movie' value='".$SOUND_URL."'><param name=quality value=high><embed id='sms_sound' src='{$SOUND_URL}' width='0' height='0' quality='autohigh' wmode='opaque' type='application/x-shockwave-flash' plugspace='http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash'></embed></object>";
}else{
    $NEW_SMS_SOUND_HTML = "";
}

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" type="text/css" href="/theme/<?php echo $LOGIN_THEME;?>/status_bar.css" />
    <title></title>
    <script type="text/javascript" src="/inc/js_lang.php"></script>
    <script type="text/javascript" src="/inc/js/utility.js"></script>

    <SCRIPT LANGUAGE="JavaScript">
        function killErrors(){
            return true;
        }
        window.onerror = killErrors;
        var ctroltime;
        var status_text=null;
        function MyLoad(){
            setTimeout("online_mon()",1000);
            clearTimeout(ctroltime);
            ctroltime=setTimeout("sms_mon()",3000);
        }

        function online_mon(req){
            if(isUndefined(req)) {
                _get("../ipanel/user/user_count.php","CHECK_SMS=<?php echo $CHECK_SMS;?>",online_mon);
                setTimeout("online_mon()",<?php echo $ONLINE_REF_SEC * 1000;?>);
            }   else   {
                var count = 0;
                if(req.status==200)
                    count = isNaN(parseInt(req.responseText)) ? 0 : parseInt(req.responseText);
                $("user_count1").value=count;
                $("user_count1").size=($("user_count1").value.length<3 ? 3 : $("user_count1").value.length);
                var online_title = sprintf(td_lang.general.msg_34, "<?php  echo $USER_TOTAL_COUNT;?>", count);
                $("user_count1").title = online_title;
                $("online_link").title = online_title;
            }
        }

        function sms_mon(req){
            if(isUndefined(req))  {
                clearTimeout(ctroltime);
                _get("../../attachment/new_sms/<?php echo $LOGIN_UID;?>.sms?now=" + new Date().getTime(),"",sms_mon);
                ctroltime=setTimeout("sms_mon()",<?php echo $SMS_REF_SEC * 1000;?>);
            }  else if(req.status==200)  {
                if(req.responseText.indexOf("1") >= 0)     {
                    $("new_sms").innerHTML="<?php echo $NEW_SMS_HTML;?>";
                    $("new_sms_sound").innerHTML="<?php echo $NEW_SMS_SOUND_HTML;?>";
                    if ( $SMS_ON == 1 )    {
                        show_sms();
                    }
                }     else     {
                    set_no_sms();
                }
            }
        }

        function set_no_sms(){
            $("new_sms").innerHTML="";
            $("new_sms_sound").innerHTML="";
        }
        function show_sms(){
            set_no_sms();
            clearTimeout(ctroltime);
            ctroltime=window.setTimeout('sms_mon()',<?php echo $SMS_REF_SEC * 1000 + 20000;?>);
            mytop=screen.availHeight-160;
            myleft=0;
            window.open("sms_show.php","show_sms_<?php echo $LOGIN_UID;?>","height=120,width=390,status=0,toolbar=no,menubar=no,location=no,scrollbars=no,top="+mytop+",left="+myleft+",resizable=yes");
        }
        function show_email(){
        }
        function show_online(){
            parent.leftmenu.view_menu(2);
        }
        function main_refresh(){
            parent.table_index.main.location.reload();
        }
        menu_flag=0;
        var STATUS_BAR_MENU;
        function show_menu(){
            mytop=screen.availHeight-480;
            myleft=screen.availWidth-260;
            if(menu_flag==0)
                STATUS_BAR_MENU=window.open("/general/ipanel/menu.php?OA_SUB_WINDOW=1","STATUS_BAR_MENU<?php echo $LOGIN_USER_ID;?>","height=400,width=200,status=0,toolbar=no,menubar=no,location=no,scrollbars=yes,top="+mytop+",left="+myleft+",resizable=no");
            STATUS_BAR_MENU.focus();
        }
        function show_feedback(){
            mytop=(screen.availHeight-430)/2;
            myleft=(screen.availWidth-600)/2;
            window.open("/module/feedback/","","height=450,width=600,status=0,toolbar=no,menubar=no,location=no,scrollbars=yes,top="+mytop+",left="+myleft+",resizable=yes");
        }
        function MyUnload(){
            if(menu_flag==1 && STATUS_BAR_MENU)   {
                STATUS_BAR_MENU.focus();
                STATUS_BAR_MENU.MAIN_CLOSE=1;
                STATUS_BAR_MENU.close();
            }
        }
    </script>
</head>
<body class="statusbar" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0" onLoad="MyLoad();" onUnload="MyUnload();">
<table border="0" width="100%" cellspacing="1" cellpadding="0" class="small">
    <tr>
        <td align="center" width="120"><a id="online_link" href="javascript:void(0);" ><?php echo sprintf( _( "在线%s人" ), "<input type='text' id='user_count1' size='3' readonly='readonly'>" );?></a></td>
        <td align="center" width="80">&nbsp;<span id="new_sms"></span><span id="new_sms_sound" style="width:1px;height:1px;"></span></td>
        <td id="status_text_container" align="center" style="font-weight: bold;">&nbsp;</td>
        <td width="140" align="center"></td>
        <td align="center" width="80">&nbsp;<span id="new_letter"></span></td>
        <td align="center" width="150">&nbsp;</td>
    </tr>
</table>
</body>
</html>