<?php
require( "../../../include/auth.php" );

function getFuncs($MENU_ID){
    global $connection;
    global $LANG_COOKIE;
    $return = array();
    $query1 = "SELECT * from SYS_FUNCTION where MENU_ID like '".$MENU_ID."%' and length(MENU_ID)=4 order by MENU_ID";
    $cursor1 = exequery( $connection, $query1 );
    while ( $ROW = mysql_fetch_array( $cursor1 ) ){
        $temp_func = array();
        $temp_func['MENU_ID1'] = $ROW['MENU_ID'];
        $temp_func['FUNC_ID'] = $ROW['FUNC_ID'];
        $temp_func['FUNC_NAME'] = $ROW['FUNC_NAME'];
        $temp_func['FUNC_CODE'] = $ROW['FUNC_CODE'];
        $temp_func['FUNC_EXT'] = unserialize( $ROW['FUNC_EXT'] );
        if ( is_array( $temp_func['FUNC_EXT'] ) && $temp_func['FUNC_EXT'][$LANG_COOKIE] != "" ){
            $temp_func['FUNC_NAME'] = $temp_func['FUNC_EXT'][$LANG_COOKIE];
        }
        $temp_func['OPEN_WINDOW'] = substr( $temp_func['FUNC_CODE'], 0, 2 ) == "1:" ? 1 : 0;
        $temp_func['FUNC_CODE'] = substr( $temp_func['FUNC_CODE'], 0, 2 ) == "1:" ? substr( $temp_func['FUNC_CODE'], 2 ) : $temp_func['FUNC_CODE'];
        if ( 10000 <= $temp_func['FUNC_ID'] && $temp_func['FUNC_ID'] <= 20000 ){
            $temp_func['FUNC_IMAGE'] = "fis";
        }else if ( strstr( $temp_func['FUNC_ID'], "http://" ) ){
            $temp_func['FUNC_IMAGE'] = "menu_url";
        }else if ( strstr( $temp_func['FUNC_CODE'], "file://" ) ){
            $temp_func['FUNC_IMAGE'] = "winexe";
        }else if ( strstr( $temp_func['FUNC_CODE'], "/" ) ){
            $temp_func['FUNC_IMAGE'] = substr( $temp_func['FUNC_CODE'], 0, strpos( $temp_func['FUNC_CODE'], "/" ) );
        }else{
            $temp_func['FUNC_IMAGE'] = $temp_func['FUNC_CODE'];
        }

        // 取下一级菜单
        if ( substr( $ROW['FUNC_CODE'], 0, 1 ) == "@" ){
            $temp_func['FUNCS'] = getFuncs2($ROW['MENU_ID']);
        }

        $return[] = $temp_func;
    }
    return $return;
}

function getFuncs2($MENU_ID){
    global $connection;
    global $LANG_COOKIE;
    $return = array();
    $query2 = "SELECT * from SYS_FUNCTION where MENU_ID like '".$MENU_ID."%' and length(MENU_ID)=6 order by MENU_ID";
    $cursor2 = exequery( $connection, $query2 );
    while( $ROW = mysql_fetch_array( $cursor2 ) ){
        $temp = array();
        $temp['FUNC_ID'] = $ROW['FUNC_ID'];
        $temp['FUNC_NAME'] = $ROW['FUNC_NAME'];
        $temp['FUNC_CODE'] = $ROW['FUNC_CODE'];
        $temp['FUNC_EXT'] = unserialize( $ROW['FUNC_EXT'] );
        if ( is_array( $temp['FUNC_EXT'] ) && $temp['FUNC_EXT'][$LANG_COOKIE] != "" ){
            $temp['FUNC_NAME'] = $temp['FUNC_EXT'][$LANG_COOKIE];
        }
        $temp['OPEN_WINDOW'] = substr( $temp['FUNC_CODE'], 0, 2 ) == "1:" ? 1 : 0;
        $temp['FUNC_CODE'] = substr( $temp['FUNC_CODE'], 0, 2 ) == "1:" ? substr( $temp['FUNC_CODE'], 2 ) : $temp['FUNC_CODE'];
        if ( 10000 <= $temp['FUNC_ID'] && $temp['FUNC_ID'] <= 20000 ){
            $temp['FUNC_IMAGE'] = "fis";
        }else if ( strstr( $temp['FUNC_CODE'], "http://" ) ){
            $temp['FUNC_IMAGE'] = "menu_url";
        }else if ( strstr( $temp['FUNC_CODE'], "file://" ) ){
            $temp['FUNC_IMAGE'] = "winexe";
        }else if ( strstr( $temp['FUNC_CODE'], "/" ) ){
            $temp['FUNC_IMAGE'] = substr( $temp['FUNC_CODE'], 0, strpos( $temp['FUNC_CODE'], "/" ) );
        }else{
            $temp['FUNC_IMAGE'] = $temp['FUNC_CODE'];
        }
        if ( $temp['FUNC_CODE'] == "bbs2/admin" ){
            $temp['FUNC_IMAGE'] = "system";
        }
        $return[] = $temp;
    }
    return $return;
}

// =============================================================================

$query = "SELECT * from SYS_MENU";
$cursor = exequery( $connection, $query );
$MENU_ID_COUNT = 0;
$MENU_ID_ARRAY_STR = '';
while ( $ROW = mysql_fetch_array( $cursor ) ){
    $MENU_ID_ARRAY_STR .= "MENU_ID_ARRAY[".$MENU_ID_COUNT.']="'.$ROW['MENU_ID'].'";'."\r\n";
    $MENU_ID_COUNT++;
}
$USER_PRIV = $_GET['USER_PRIV'];
$query = "SELECT * from USER_PRIV where USER_PRIV='".$USER_PRIV."'";
$cursor = exequery( $connection, $query );
if ( $ROW = mysql_fetch_array( $cursor ) ){
    $PRIV_NO = $ROW['PRIV_NO'];
    $PRIV_NAME = $ROW['PRIV_NAME'];
    $USER_FUNC_ID_STR = $ROW['FUNC_ID_STR'];
}

$data = array();
$COUNT_FUNC = 0;
$query = "SELECT * from SYS_MENU order by MENU_ID";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) ){
    $temp = array();
    $temp['MENU_ID'] = $ROW['MENU_ID'];
    $temp['MENU_NAME'] = $ROW['MENU_NAME'];
    $temp['FUNC_ID_STR'] = $ROW['FUNC_ID_STR'];
    $temp['IMAGE'] = $ROW['IMAGE'];
    $temp['MENU_EXT'] = unserialize( $ROW['MENU_EXT'] );
    if ( is_array( $temp['MENU_EXT'] ) && $temp['MENU_EXT'][$LANG_COOKIE] != "" ){
        $temp['MENU_NAME'] = $temp['MENU_EXT'][$LANG_COOKIE];
    }
    // 下级菜单
    $temp['FUNCS'] = getFuncs($ROW['MENU_ID']);

    $data[] = $temp;
}
?>
<html>
<head>
    <title><?php echo _( "编辑角色权限" );?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo SITE_URL;?>assets/js/utility.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL;?>assets/js/module.js"></script>
    <script src="<?php echo SITE_URL;?>assets/js/dialog.js"></script>
    <script>
        var MENU_ID_ARRAY = new Array();
        <?php echo $MENU_ID_ARRAY_STR;?>

        function check_all(menu_all,MENU_ID){

            //var cb = document.getElementsByName(MENU_ID);
            var cb = document.getElementsByName(MENU_ID)
            if(!cb || cb.length==0)   return;
            for (i=0;i<cb.length;i++) {
                if(menu_all.checked)
                    cb[i].checked=true;
                else
                    cb[i].checked=false;
            }
        }
        function check_all_next(menu_all,MENU_ID){

            var cball=document.all;
            if(!cball || cball.length==0)
                return;
            for(m=0;m<cball.length;m++) {
                if(cball[m].id.substring(0,7)==MENU_ID) {
                    if(menu_all.checked)
                        cball[m].checked=true;
                    else
                        cball[m].checked=false;
                }
            }
        }
        function mysubmit(){
            func_id_str="";
            for(var j=1;j<=<?php echo $MENU_ID_COUNT;?>;j++)  {
                var cb = document.getElementsByName(MENU_ID_ARRAY[j-1]);
                if(!cb || cb.length==0)
                    continue;
                for(i=0;i<cb.length;i++)    {
                    if(cb[i].checked)        {
                        func_id_str+=cb[i].value + ",";
                    }
                }
            }
            form1.FUNC_ID_STR.value=func_id_str;
            //alert(document.getElementById("FUNC_ID_STR").value);
            form1.submit();
        }
        window.onscroll=window.onresize=function(){
            op_btn=document.getElementById("OP_BTN");
            if(!op_btn)
                return false;
            op_btn.style.left=document.body.clientWidth+document.body.scrollLeft-160;
            op_btn.style.top =document.body.scrollTop +5;
        };
    </script>
</head>
<body class="bodycolor" topmargin="5">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
    <tr>
        <td class="Big">
            <img src="<?php echo SITE_URL;?>assets/images/edit.gif" WIDTH="22" HEIGHT="20" align="absmiddle">
            <span class="big3"><?php echo _( "编辑角色权限" );?>-(<?php echo $PRIV_NAME;?>)</span>
            &nbsp;&nbsp;
            <div id="OP_BTN" style="width:150px;top:5px;right:20px;position:absolute;">
                <form name="form1" method="post" action="update_priv.php">
                    <input type="hidden" value="" name="FUNC_ID_STR" id="FUNC_ID_STR">
                    <input type="hidden" value="<?php echo $USER_PRIV;?>" name="USER_PRIV">
                    <input type="hidden" id="SUPER_PASS_HIDDEN" name="SUPER_PASS_HIDDEN">
                    <input type="button" value="<?php echo _( "确定" );?>" class="BigButton" onclick="mysubmit();">
                    &nbsp;&nbsp;
                    <input type="button" value="<?php echo _( "返回" );?>" class="BigButton" onclick="location='manage.php'">
                </form>
            </div>
        </td>
    </tr>
</table>

<table border="0" cellspacing="2" class="small" cellpadding="3" align="center">
    <tr class="TableContent">
        <?php $COUNT_FUNC_ = 1;?>
        <?php foreach($data as $d):?>
        <td  valign="top">
            <table class="TableBlock" align="center">
                <tr class="TableHeader" title="<?php echo $d['MENU_NAME'];?>">
                    <td nowrap>
                        <input type="checkbox" name="MENU_<?php echo $d['MENU_ID'];?>" id="MENU_<?php echo $d['MENU_ID'];?>_<?php echo $COUNT_FUNC_;?>" onClick="check_all(this,'<?php echo $d['MENU_ID'];?>');" />
                        <img src="<?php echo SITE_URL;?>assets/images/menu/<?php echo $d['IMAGE'];?>.gif" width=19 height=17>
                        <label for="MENU_<?php echo $d['MENU_ID'];?>_<?php echo $COUNT_FUNC_;?>" />
                        <b><?php echo $d['MENU_NAME'],$d['MENU_ID'];?></b>
                        </label>
                    </td>
                </tr>
                <?php if($d['FUNCS']):?>
                <?php foreach($d['FUNCS'] as $f):?>
                <tr title="<?php echo $f['FUNC_NAME'];?>">
                    <td class="TableData" nowrap>
                        <input type="checkbox" name="<?php echo $d['MENU_ID'];?>" id="<?php echo $d['MENU_ID'];?>_<?php echo $COUNT_FUNC_;?>" value="<?php echo $f['FUNC_ID'];?>" <?php if ( find_id( $USER_FUNC_ID_STR, $f['FUNC_ID'] ) ){echo "checked";}?> <?php if ( substr( $f['FUNC_CODE'], 0, 1 ) == "@" ){?> onClick="check_all_next(this,'<?php echo $d['MENU_ID'];?>_<?php echo $f['MENU_ID1'];?>');"<?php }?> />
                        <img src="<?php echo SITE_URL;?>assets/images/menu/<?php echo $f['FUNC_IMAGE'];?>.gif" width=19 height=17>
                        <label for="<?php echo $f['MENU_ID'];?>_<?php echo $COUNT_FUNC_;?>"><?php echo $f['FUNC_NAME'],$f['FUNC_ID'];?></label>
                        <?php if($f['FUNCS']):?>
                        <?php foreach($f['FUNCS'] as $m):?>
                        <br>&nbsp;
                        <input type="checkbox" name="<?php echo $d['MENU_ID'];?>" id="<?php echo $d['MENU_ID'];?>_<?php echo $f['MENU_ID1'];?>_<?php echo $COUNT_FUNC;?>"   value="<?php echo $m['FUNC_ID'];?>" <?php if ( find_id( $USER_FUNC_ID_STR, $m['FUNC_ID'] ) ){echo "checked";}?> />
                        <img src="<?php echo SITE_URL;?>assets/images/menu/<?php echo $m['FUNC_IMAGE'];?>.gif" width=19 height=17>
                        <label for="<?php echo $m['MENU_ID'];?>_<?php echo $f['MENU_ID1'];?>_<?php echo $COUNT_FUNC;?>"><?php echo $m['FUNC_NAME'],$f['MENU_ID1'];?></label>
                        <?php $COUNT_FUNC_++;?>
                        <?php endforeach;?>
                        <?php endif;?>
                    </td>
                </tr>
                <?php $COUNT_FUNC_++;?>
                <?php endforeach;?>
                <?php endif;?>
            </table>
        </td>
        <?php $COUNT_FUNC_++;?>
        <?php endforeach;?>
    </tr>
</table>

<input type="text" value="<?php echo $USER_PRIV;?>" name="USER_PRIV" />

</body>
</html>