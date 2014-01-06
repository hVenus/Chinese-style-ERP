<?php
require("../../include/auth.php");
$name = isset($_POST["CategoryName"])?$_POST["CategoryName"]:"";
$code = isset($_POST["CategoryCode"])?$_POST["CategoryCode"]:"";
$sort = isset($_POST["SortNo"])?$_POST["SortNo"]:0;
$parent_id = isset($_POST["ParentID"])?$_POST["ParentID"]:0;
$msg = "";
if($name == ""){
    $msg = "分类名称不能为空";
}
if($code == ""){
    $msg = "分类代码不能为空";
}
if($msg == "" && is_numeric($parent_id)){
    $sql = 'INSERT INTO product_categories SET parent_id='.(int)$parent_id.', cate_name="'.mysql_real_escape_string($name).'", cate_code="'.mysql_real_escape_string($code).'", sort_no='.(int)$sort.', invalid=0 ';
    $cursor = exequery( $connection, $sql );
    if($cursor === true){
        $msg = "分类已保存";
    }else{
        $msg = "分类保存失败";
    }
    
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="<?php echo SITE_URL;?>assets/js/jquery.min.js"></script>
        <script>
        $(document).ready(function(){
            parent.menu_list.location.reload();
        });
        </script>
    </head>
    <body>
        <div class="container">
            <?php echo $msg;?>
        </div>
    </body>
</html>