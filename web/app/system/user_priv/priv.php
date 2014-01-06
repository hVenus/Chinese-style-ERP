<?php
require( "../../../include/auth.php" );
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo _( "添加/删除权限" );?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo SITE_URL;?>assets/js/utility.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL;?>assets/js/module.js"></script>
    <script>
        var MENU_ID_ARRAY = new Array();
                <?php
$MENU_ID_COUNT = 0;
$query = "SELECT * from SYS_MENU";
$cursor = exequery( $connection, $query );
while ( $ROW = mysql_fetch_array( $cursor ) )
{
    echo "    MENU_ID_ARRAY[";
    echo $MENU_ID_COUNT;
    echo "]=\"";
    echo $ROW['MENU_ID'];
    echo "\";\r\n";
    ++$MENU_ID_COUNT;
}
?>
        function check_all(menu_all,MENU_ID){
            var cb = document.getElementsByName(MENU_ID);
            if(!cb || cb.length==0)return;
            for (i=0;i<cb.length;i++){
                if(menu_all.checked)
                    cb[i].checked=true;
                else
                    cb[i].checked=false;
            }
        }
        var check_all_var=true;
        function select_all(){
            var cb = document.getElementsByName("USER_PRIV");
            if(!cb || cb.length==0)
                return;
            for (i=0;i<document.all("USER_PRIV").length;i++){
                if(check_all_var)
                    cb[i].checked=true;
                else
                    cb[i].checked=false;
            }
            check_all_var=!check_all_var;
        }
        function mysubmit(){
            var user_priv_str="", user_priv=document.getElementsByName("USER_PRIV");
            for(i=0;i<user_priv.length;i++){
                if(user_priv[i].checked)
                    user_priv_str+=user_priv[i].value+",";
            }
            if(user_priv_str==""){
                alert("<?php echo _( "请选择角色" );?>");
                return;
            }
            func_id_str="";
            for(j=1;j<=<?php echo $MENU_ID_COUNT;?>;j++){
                var cb = document.getElementsByName(MENU_ID_ARRAY[j-1]);
            }
            if(!cb || cb.length==0)
                continue;
            for(i=0;i<cb.length;i++){
                if(cb[i].checked){
                    func_id_str+=cb[i].value +",";
                }
            }
            document.form1.FUNC_ID_STR.value=func_id_str;
            document.form1.USER_PRIV_STR.value=user_priv_str;
            form1.submit();
        }
        window.onscroll=window.onresize=function(){
            op_btn=document.getElementById("OP_BTN");
            if(!op_btn) return false;
            op_btn.style.left=document.body.clientWidth+document.body.scrollLeft-80;
            op_btn.style.top =document.body.scrollTop +5;
        };
    </script>
</head>
<body class="bodycolor" topmargin="5">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
    <tr>
        <td class="Big"><img src="<?php echo SITE_URL;?>assets/images/edit.gif" WIDTH="22" HEIGHT="20" align="absmiddle">
            <span class="big3"><?php echo _( "添加/删除权限" );?></span>&nbsp;&nbsp;
            <div id="OP_BTN" style="top:5px;right:25px;position:absolute;">
                <input type="button" value="<?php echo _( "确定" );?>" class="MyButton BigButton" onclick="mysubmit();">
            </div>
        </td>
    </tr>
</table>
<table class="TableBlock" width="100%" align="center">
    <form method="post" name="form1" action="add_remove_priv.php">
        <tr class="TableData">
            <td nowrap width="80"><b><?php echo _( "操作：" );?></b></td>
            <td>
                <input type="radio" name="OPERATION" value="0" id="OPERATION0" checked>
                <label for="OPERATION0"><?php echo _( "添加权限" );?></label>
                <input type="radio" name="OPERATION" value="1" id="OPERATION1">
                <label for="OPERATION1"><?php echo _( "删除权限" );?></label>
            </td>
        </tr>
        <tr class="TableData">
            <td nowrap><b><?php echo _( "角色：" );?></b>
                <a href="javascript:select_all();"><u><?php echo _( "全选" );?></u></a>
            </td>
            <td>

                <?php
                $query = "SELECT * from USER_PRIV order by PRIV_NO";
                $cursor = exequery( $connection, $query );
                while ( $ROW = mysql_fetch_array( $cursor ) ){
                    $USER_PRIV = $ROW['USER_PRIV'];
                    $PRIV_NAME = $ROW['PRIV_NAME'];
                ?>
                <input type="checkbox" name="USER_PRIV" value="<?php echo $USER_PRIV;?>" id="USER_PRIV<?php  echo $USER_PRIV;?>">
                <label for="USER_PRIV<?php echo $USER_PRIV;?>"><?php echo $PRIV_NAME;?></label>&nbsp;
                <?php }?>
            </td>  
        </tr> 
        <input type="hidden" name="USER_PRIV_STR" value=""> 
        <input type="hidden" name="FUNC_ID_STR" value="">  
    </form>
</table>
<table border="0" cellspacing="0" class="small" cellpadding="3" align="center">
    <tr class="TableContent">
        <?php
        $COUNT_FUNC = 0;
        $query = "SELECT * from SYS_MENU order by MENU_ID";
        $cursor = exequery( $connection, $query );
        while ( $ROW = mysql_fetch_array( $cursor ) ){
            $MENU_ID = $ROW['MENU_ID'];
            $MENU_NAME = $ROW['MENU_NAME'];
            $MENU_EXT = unserialize( $ROW['MENU_EXT'] );
            if ( is_array( $MENU_EXT ) && $MENU_EXT[$LANG_COOKIE] != "" ){
                $MENU_NAME = $MENU_EXT[$LANG_COOKIE];
            }
            $FUNC_ID_STR = $ROW['FUNC_ID_STR'];
            $IMAGE = $ROW['IMAGE'];
            $COUNT_FUNC++;
        ?>
        <td valign="top">  
            <table class="TableBlock" align="center">     
                <tr class="TableHeader" title="<?php echo $MENU_NAME;?>">      
                    <td nowrap>
                        <input type="checkbox" name="MENU_<?php echo $MENU_ID;?>" id="MENU_<?php echo $MENU_ID;?>_<?php echo $COUNT_FUNC;?>" onclick="check_all(this,'<?php echo $MENU_ID;?>');"> 
                        <img src="/images/menu/<?php echo $IMAGE;?>.gif" width=19 height=17> 
                        <label for="MENU_<?php echo $MENU_ID;?>_<?php echo $COUNT_FUNC;?>">
                            <b><?php echo $MENU_NAME;?></b>
                        </label>
                    </td>
                </tr>
                    <?php 
                    $query1 = "SELECT * from SYS_FUNCTION where MENU_ID like '".$MENU_ID."%' and length(MENU_ID)=4 order by MENU_ID";
                    $cursor1 = exequery( $connection, $query1 );
                    while ( $ROW = mysql_fetch_array( $cursor1 ) ){
                        $MENU_ID1 = $ROW['MENU_ID'];
                        $FUNC_ID = $ROW['FUNC_ID'];
                        $FUNC_NAME = $ROW['FUNC_NAME'];
                        $FUNC_CODE = $ROW['FUNC_CODE'];
                        $FUNC_EXT = unserialize( $ROW['FUNC_EXT'] );
                        if ( is_array( $FUNC_EXT ) && $FUNC_EXT[$LANG_COOKIE] != "" ){
                            $FUNC_NAME = $FUNC_EXT[$LANG_COOKIE];
                        }
                        $OPEN_WINDOW = substr( $FUNC_CODE, 0, 2 ) == "1:" ? 1 : 0;
                        $FUNC_CODE = substr( $FUNC_CODE, 0, 2 ) == "1:" ? substr( $FUNC_CODE, 2 ) : $FUNC_CODE;
                        if ( 10000 <= $FUNC_ID && $FUNC_ID <= 20000 ){
                            $FUNC_IMAGE = "fis";
                        }else if ( strstr( $FUNC_CODE, "http://" ) ){
                            $FUNC_IMAGE = "menu_url";
                        }else if ( strstr( $FUNC_CODE, "file://" ) ){
                            $FUNC_IMAGE = "winexe";
                        }else if ( strstr( $FUNC_CODE, "/" ) ){
                            $FUNC_IMAGE = substr( $FUNC_CODE, 0, strpos( $FUNC_CODE, "/" ) );
                        }else{
                            $FUNC_IMAGE = $FUNC_CODE;
                        }
                        $COUNT_FUNC++;
                    ?>
                <tr title="<?php echo $FUNC_NAME;?>">
                    <td class="TableData" nowrap>
                        <input type="checkbox" name="<?php echo $MENU_ID;?>" id="<?php echo $MENU_ID;?>_<?php echo $COUNT_FUNC;?>" value="<?php echo $FUNC_ID;?>">
                        <img src="/images/menu/<?php echo $FUNC_IMAGE;?>.gif" width=19 height=17> 
                        <label for="<?php echo $MENU_ID;?>_<?php echo $COUNT_FUNC;?>"><?php echo $FUNC_NAME;?></label>
                            <?php 
                            if ( substr( $FUNC_CODE, 0, 1 ) == "@" ){
                                $query2 = "SELECT * from SYS_FUNCTION where MENU_ID like '".$MENU_ID1."%' and length(MENU_ID)=6 order by MENU_ID";
                                $cursor2 = exequery( $connection, $query2 );
                                while ( $ROW = mysql_fetch_array( $cursor2 ) ){
                                    $FUNC_ID = $ROW['FUNC_ID'];
                                    $FUNC_NAME = $ROW['FUNC_NAME'];
                                    $FUNC_CODE = $ROW['FUNC_CODE'];
                                    $FUNC_EXT = unserialize( $ROW['FUNC_EXT'] );
                                    if ( is_array( $FUNC_EXT ) && $FUNC_EXT[$LANG_COOKIE] != "" ){
                                        $FUNC_NAME = $FUNC_EXT[$LANG_COOKIE];
                                    }
                                    $OPEN_WINDOW = substr( $FUNC_CODE, 0, 2 ) == "1:" ? 1 : 0;
                                    $FUNC_CODE = substr( $FUNC_CODE, 0, 2 ) == "1:" ? substr( $FUNC_CODE, 2 ) : $FUNC_CODE;
                                    if ( 10000 <= $FUNC_ID && $FUNC_ID <= 20000 ){
                                        $FUNC_IMAGE = "fis";
                                    }else if ( strstr( $FUNC_CODE, "http://" ) ){
                                        $FUNC_IMAGE = "menu_url";
                                    }else if ( strstr( $FUNC_CODE, "file://" ) ){
                                        $FUNC_IMAGE = "winexe";
                                    }else if ( strstr( $FUNC_CODE, "/" ) ){
                                        $FUNC_IMAGE = substr( $FUNC_CODE, 0, strpos( $FUNC_CODE, "/" ) );
                                    }else{
                                        $FUNC_IMAGE = $FUNC_CODE;
                                    }
                                    if ( $FUNC_CODE == "bbs2/admin" ){
                                        $FUNC_IMAGE = "system";
                                    }
                                    $COUNT_FUNC++;
                                    ?>
                        <br>&nbsp;    
                        <input type="checkbox" name="<?php echo $MENU_ID;?>" id="<?php echo $MENU_ID;?>_<?php echo $COUNT_FUNC;?>" value="<?php echo $FUNC_ID;?>">
                        <img src="/images/menu/<?php echo $FUNC_IMAGE;?>.gif" width=19 height=17> 
                        <label for="<?php echo $MENU_ID;?>_<?php echo $COUNT_FUNC;?>"><?php echo $FUNC_NAME;?></label>
                            <?php }?>
                            <?php }?>
                    </td>    
                </tr>
                <?php } ?>
            </table>  
        </td>
        <?php }?>
    </tr>
</table>
</body>
</html>