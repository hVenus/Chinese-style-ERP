<?php
require( "../../../include/auth.php" );
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo _( "调整角色序号高低" );?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script>
        function func_up(){
            sel_count=0;
            for (i=select1.options.length-1; i>=0; i--){
                if(select1.options(i).selected)
                    sel_count++;
            }
            if(sel_count==0){
                alert("<?php echo _( "调整顺序时，请选择其中一项！" );?>");
                return;
            }
            else if(sel_count>1){
                alert("<?php echo _( "调整顺序时，只能选择其中一项！" );?>");
                return;
            }
            i=select1.selectedIndex;
            if(i!=0){
                var cur_no=select1.options(i).no;
                var my_option = document.createElement("OPTION");
                my_option.text=select1.options(i).text;
                my_option.value=select1.options(i).value;
                my_option.no=select1.options(i-1).no;
                select1.add(my_option,i-1);
                select1.remove(i+1);
                select1.options(i-1).selected=true;
                select1.options(i).no=cur_no;
            }
        }
        function func_down(){
            sel_count=0;
            for (i=select1.options.length-1; i>=0; i--){
                if(select1.options(i).selected)
                    sel_count++;
            }
            if(sel_count==0){
                alert("<?php echo _( "调整顺序时，请选择其中一项！" );?>");
                return;
            }
            else if(sel_count>1){
                alert("<?php echo _( "调整顺序时，只能选择其中一项！" );?>");
                return;
            }
            i=select1.selectedIndex;
            if(i!=select1.options.length-1){
                var cur_no=select1.options(i).no;
                var my_option = document.createElement("OPTION");
                my_option.text=select1.options(i).text;
                my_option.value=select1.options(i).value;
                my_option.no=select1.options(i+1).no;
                select1.add(my_option,i+2);
                select1.remove(i);
                select1.options(i+1).selected=true;
                select1.options(i).no=cur_no;
            }
        }
        function mysubmit(){
            priv_str=no_str="";
            for (i=0; i< select1.options.length; i++){
                priv_str+=select1.options(i).value+",";
                no_str+=select1.options(i).no+",";
            }
            location="priv_no_update.php?PRIV_STR=" + priv_str + "&NO_STR=" + no_str;
        }
    </script>
</head>
<body class="bodycolor" topmargin="5">
<table border="0" width="100%" cellspacing="0" cellpadding="3" class="small">
    <tr>
        <td class="Big">
            <img src="<?php echo SITE_URL;?>assets/images/edit.gif" WIDTH="22" HEIGHT="20" align="absmiddle">
            <span class="big3"><?php echo _( "调整角色序号高低" );?></span>
        </td>
    </tr>
</table>
<br>
<table class="TableBlock" width="400" align="center">
    <tr class="TableHeader">
        <td align="center"><b><?php echo _( "角色" );?></b></td>
        <td align="center"><?php echo _( "排序" );?></td>
    </tr>
    <tr class="TableData">
        <td valign="top" align="center">
            <select name="select1" MULTIPLE style="width:200;height:280">
                <?php
                $query = "SELECT * from USER_PRIV order by PRIV_NO";
                $cursor = exequery( $connection, $query );
                while ( $ROW = mysql_fetch_array( $cursor ) )
                {
                    $USER_PRIV = $ROW['USER_PRIV'];
                    $PRIV_NAME = $ROW['PRIV_NAME'];
                    $PRIV_NO = $ROW['PRIV_NO'];
                    echo "       <option value=\"";
                    echo $USER_PRIV;
                    echo "\" no=\"";
                    echo $PRIV_NO;
                    echo "\">";
                    echo $PRIV_NAME;
                    echo "</option>\r\n\r\n";
                }
                ?>
            </select>
        </td>
        <td align="center">
            <input type="button" class="MyButton SmallInput" value=" ↑ " onclick="func_up();"><br><br>
            <input type="button" class="MyButton SmallInput" value=" ↓ " onclick="func_down();">
        </td>
    </tr>
    <tr class="TableControl">
        <td align="center" valign="top" colspan="4">
            <input type="button" class="MyButton BigButton" value="<?php echo _( "保存" );?>" onclick="mysubmit();">&nbsp;&nbsp;
        </td>
    </tr>
</table>
</body>
</html>
