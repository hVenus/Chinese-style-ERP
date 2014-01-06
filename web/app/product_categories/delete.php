<?php
require("../../include/auth.php");
$id = isset($_POST["id"])?$_POST["id"]:0;
$msg = "";
if($id == 0){
    $msg = "系统错误，请联系管理员。";
}
if($msg == "" && is_numeric($id) && $id>0){
    $pc = new ProductCategories();
    $ids = $pc->getCategoiresIDs($id);
    $sql = 'DELETE FROM product_categories WHERE id in ('.trim($ids,',').') ';
    $cursor = exequery( $connection, $sql );
    if($cursor === true){
        $msg = "分类已删除";
    }else{
        $msg = "分类删除失败";
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