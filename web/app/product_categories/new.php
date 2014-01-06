<?php
require( "../../include/auth.php" );
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
        });
        </script>
    </head>
    <body>
        <div class="container">
            <form name="form1" action="save.php" method="post" class="form-horizontal" role="form">
                <div class="form-group">
                    <label for="InputCategoryName" class="col-sm-2  control-label">分类名称</label>
                    <div  class="col-sm-3">
                        <input type="text" class="form-control" id="InputCategoryName" name="CategoryName" placeholder="Enter Category Name">
                    </div>
                </div>
                <div class="form-group">
                  <label for="InputCategoryCode" class="col-sm-2  control-label">分类代码</label>
                  <div class="col-sm-3">
                      <input type="text" class="form-control" id="InputCategoryCode" name="CategoryCode" placeholder="Enter Category Code">
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
                        <button type="button" class="btn btn-default" id="sb">保存</button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>