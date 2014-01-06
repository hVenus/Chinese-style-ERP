<?php
/**
 * 产品分类列表
 */
require("../../include/auth.php");
$pc = new ProductCategories();
$list = $pc->getAllCategories();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo SITE_URL;?>assets/ztree/css/zTreeStyle/zTreeStyle.css" type="text/css">
    <script type="text/javascript" src="<?php echo SITE_URL;?>assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL;?>assets/ztree/js/jquery.ztree.core-3.5.min.js"></script>
    <SCRIPT type="text/javascript">
        <!--
        var setting = {
            view: {
                dblClickExpand: dblClickExpand
            },
            data: {
                simpleData: {
                    enable: true
                }
            },
            callback: {
                //beforeClick: beforeClick,
                //onClick: onClick
            }
        };
        
        var zNodes = [];

        zNodes.push({ id:0, pId:0, name:"所有产品分类", open:true, url:"blank.php", target:"menu_edit"});
        
        <?php if(is_array($list)){?>
            <?php foreach($list as $l){?>
                zNodes.push({ id:<?php echo $l['id'];?>, pId:<?php echo $l['parent_id'];?>, name:"<?php echo $l['cate_name'];?>", open:true,  url:"edit.php?id=<?php echo $l['id'];?>", target:"menu_edit"});
            <?php }?>
        <?php }?>
        
        function dblClickExpand(treeId, treeNode) {
            return treeNode.level > 0;
        }

        function beforeClick(treeId, treeNode, clickFlag) {
            //className = (className === "dark" ? "":"dark");
            //showLog("[ "+getTime()+" beforeClick ]&nbsp;&nbsp;" + treeNode.name );
            //return (treeNode.click != false);
            alert(treeNode['id']+"#"+treeNode['name']);
        }
        
        function onClick(event, treeId, treeNode, clickFlag) {
            alert(treeNode['id']+"#"+treeNode['name']);
            //showLog("[ "+getTime()+" onClick ]&nbsp;&nbsp;clickFlag = " + clickFlag + " (" + (clickFlag===1 ? "普通选中": (clickFlag===0 ? "<b>取消选中</b>" : "<b>追加选中</b>")) + ")");
        }
        
        $(document).ready(function(){
            $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        });
        //-->
    </SCRIPT>
    <style type="text/css">
    .ztree li span.button.switch.level0 {visibility:hidden; width:1px;}
    .ztree li ul.level0 {padding:0; background:none;}
    </style>
</head>
<body>
<div class="content_wrap">
    <div class="zTreeDemoBackground left">
        <ul id="treeDemo" class="ztree"></ul>
    </div>
</div>
</body>
</html>