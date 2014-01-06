<?php
require('../../include/auth.php');
$id = isset($_GET['id'])?$_GET['id']:0;
if($id>0){
    $pc = new ProductCategories();
    $cate = $pc->getCategory($id);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>新建分类</title>
        <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script type="text/javascript" src="<?php echo SITE_URL;?>assets/js/jquery.min.js"></script>
        <script>
        $(document).ready(function(){
            $("#sb").click(function(){
                var category_name = $("#InputCategoryName").val();
                var category_code = $("#InputCategoryCode").val();
                var sort_no = $("#InputSortNo").val();
                if(category_name.trim() == ""){
                    alert("分类名称不能为空");
                    return false;
                }
                if(category_code.trim() == ""){
                    alert("分类代码不能为空");
                    return false;
                }
                
                document.form1.submit();
            });
            $("#sb2").click(function(){
                var category_name = $("#InputCategoryName").val();
                var category_code = $("#InputCategoryCode").val();
                var sort_no = $("#InputSortNo").val();
                if(category_name.trim() == ""){
                    alert("分类名称不能为空");
                    return false;
                }
                if(category_code.trim() == ""){
                    alert("分类代码不能为空");
                    return false;
                }
                
                document.form2.submit();
            });
            $("#sb3").click(function(){
                var c = confirm("确定删除本分类及其下属分类吗？");
                if(c === true){
                    document.form3.submit();
                }
                return false;
            });
        });
        </script>
    </head>
    <body>
        <div class="container">
            <h4>修改分类信息</h4>
            <form name="form1" action="update.php" method="post" class="form-horizontal" role="form">
                <div class="form-group">
                    <label for="InputCategoryName" class="col-sm-2  control-label">分类名称</label>
                    <div  class="col-sm-3">
                        <input type="text" class="form-control" id="InputCategoryName" name="CategoryName" placeholder="Enter Category Name" value="<?php echo $cate['cate_name']?>">
                    </div>
                </div>
                <div class="form-group">
                  <label for="InputCategoryCode" class="col-sm-2  control-label">分类代码</label>
                  <div class="col-sm-3">
                      <input type="text" class="form-control" id="InputCategoryCode" name="CategoryCode" placeholder="Enter Category Code" value="<?php echo $cate['cate_code']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="InputSortNo" class="col-sm-2  control-label">排序号</label>
                  <div class="col-sm-2">
                      <input type="number" class="form-control" id="InputSortNo" name="SortNo" placeholder="Enter SortNo" value="<?php echo $cate['sort_no']?>">
                  </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-default" id="sb">保存</button>
                    </div>
                </div>
                <input type="hidden" name="id"  value="<?php echo $cate['id']?>">
                <input type="hidden" name="ParentID"  value="<?php echo $cate['parent_id']?>">
            </form>
            <hr>
            <div>
                <h4>为【<?php echo $cate['cate_name']?>】添加子分类</h4>
                <form name="form2" action="add_child.php" method="post" class="form-horizontal" role="form">
                <div class="form-group">
                    <label for="InputCategoryName" class="col-sm-2  control-label">分类名称</label>
                    <div  class="col-sm-3">
                        <input type="text" class="form-control" id="InputCategoryName" name="CategoryName" placeholder="Enter Category Name">
                    </div>
                </div>
                <div class="form-group">
                  <label for="InputCategoryCode" class="col-sm-2  control-label">分类代码</label>
                  <div class="col-sm-3">
                      <input type="text" class="form-control" id="InputCategoryCode" name="CategoryCode" placeholder="Enter Category Code" >
                  </div>
                </div>
                <div class="form-group">
                  <label for="InputSortNo" class="col-sm-2  control-label">排序号</label>
                  <div class="col-sm-2">
                      <input type="number" class="form-control" id="InputSortNo" name="SortNo" placeholder="Enter SortNo" value="0">
                  </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-default" id="sb2">保存</button>
                    </div>
                </div>
                <input type="hidden" name="ParentID"  value="<?php echo $cate['id']?>">
            </form>
            </div>
            <hr>
            <div>
                <h4>删除【<?php echo $cate['cate_name']?>】分类</h4>
                <p class="text-danger">删除本分类后将不可恢复，并且本分类下的子分类也将一起删除。</p>
                <form name="form3" action="delete.php" method="post" class="form-horizontal" role="form">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="button" class="btn btn-default" id="sb3">删除</button>
                    </div>
                </div>
                <input type="hidden" name="id"  value="<?php echo $cate['id']?>">
                </form>
            </div>
        </div>
    </body>
</html>