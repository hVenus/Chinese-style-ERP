<?php
include_once( "inc/auth.php" );
include_once( "inc/utility_role.php" );
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
$menu1 = getMainMenuLevel1();
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <link rel="stylesheet" href="/js/jquery-zTree/css/zTreeStyle/zTreeStyle.css" type="text/css">
    
    <script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>

    <script type="text/javascript" src="/js/jquery-zTree/js/jquery.ztree.core-3.5.js"></script>
</head>
<style>
 html, body, div, span, applet, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, font, img, ins, kbd, q, s, samp, small, strike, strong, sub, sup, tt, var, dl, dt, dd, ol, ul, li, fieldset, form, label, legend, table, caption, tbody, tfoot, thead, tr, th, td {
    margin: 0;padding: 0;border: 0;outline: 0;font-weight: inherit;font-style: inherit;font-size: 100%;font-family: inherit;vertical-align: baseline;}
body {color: #2f332a;font: 15px/21px Arial, Helvetica, simsun, sans-serif;background: #f0f6e4 \9;}
h1, h2, h3, h4, h5, h6 {color: #2f332a;font-weight: bold;font-family: Helvetica, Arial, sans-serif;padding-bottom: 5px;}
h1 {font-size: 24px;line-height: 34px;text-align: center;}
h2 {font-size: 14px;line-height: 24px;padding-top: 5px;}
h6 {font-weight: normal;font-size: 12px;letter-spacing: 1px;line-height: 24px;text-align: center;}
a {color:#3C6E31;text-decoration: underline;}
a:hover {background-color:#3C6E31;color:white;}
input.radio {margin: 0 2px 0 8px;}
input.radio.first {margin-left:0;}
input.empty {color: lightgray;}
code {color: #2f332a;}
.highlight_red {color:#A60000;}
.highlight_green {color:#A7F43D;}
li {list-style: circle;font-size: 12px;}
li.title {list-style: none;}
ul.list {margin-left: 17px;}

div.content_wrap {width: 190px;height:100%;}
div.content_wrap div.left{float: left;width: 250px;}
div.content_wrap div.right{float: right;width: 340px;}
div.zTreeDemoBackground {width:250px;height:100%;text-align:left;}

ul.ztree {border: 1px solid #617775;background: #f0f6e4;width:190px;height:100%;overflow-y:scroll;overflow-x:auto;padding: 0px;}
ul.log {border: 1px solid #617775;background: #f0f6e4;width:300px;height:170px;overflow: hidden;}
ul.log.small {height:45px;}
ul.log li {color: #666666;list-style: none;padding-left: 10px;}
ul.log li.dark {background-color: #E3E3E3;}

/* ruler */
div.ruler {height:20px; width:220px; background-color:#f0f6e4;border: 1px solid #333; margin-bottom: 5px; cursor: pointer}
div.ruler div.cursor {height:20px; width:30px; background-color:#3C6E31; color:white; text-align: right; padding-right: 5px; cursor: pointer}
</style>
<script>

</script>
<script type="text/javascript">
var setting = {
    data: {
        simpleData: {
            enable: true
        }
    },
    callback: {
        beforeClick: beforeClick,
        onClick: onClick
    }
};

var zNodes =[
    <?php if($menu1):?>
        <?php foreach($menu1 as $m1):?>
            { id:'<?php echo $m1['MENU_ID']?>', pId:'0', name:"<?php echo $m1['MENU_NAME']?>", code:""},
            <?php $menu2 = getMainMenuLevel2($m1['MENU_ID']);?>
            <?php if($menu2):?>
                <?php foreach($menu2 as $m2):?>
                    { id:'<?php echo $m2['MENU_ID']?>', pId:'<?php echo $m1['MENU_ID']?>', name:"<?php echo $m2['FUNC_NAME']?>", code:"<?php echo $m2['FUNC_CODE']?>"},
                    <?php $menu3 = getMainMenuLevel3($m2['MENU_ID']);?>
                    <?php if($menu3):?>
                        <?php foreach($menu3 as $m3):?>
                            { id:'<?php echo $m3['MENU_ID']?>', pId:'<?php echo $m2['MENU_ID']?>', name:"<?php echo $m3['FUNC_NAME']?>", code:"<?php echo $m3['FUNC_CODE']?>"},
                        <?php endforeach;?>
                    <?php endif;?>
                <?php endforeach;?>
            <?php endif;?>
        <?php endforeach;?>
    <?php endif;?>
];

var log, className = "dark";

function beforeClick(treeId, treeNode, clickFlag) {
    return (treeNode.click != false);
}

function onClick(event, treeId, treeNode, clickFlag) {
    //console.log(treeNode.id);
    //console.log(treeNode.code);
    var t =window.parent.parent.frames[2];
    if(treeNode.code != "" && treeNode.code != undefined && treeNode.code != null){
        var s = treeNode.code.substr(0, 1);
        if(s != '@'){
            t.frames['main'].location="/general/"+treeNode.code+"?lc=<?php echo $i18n_COOKIE;?>";
        }
    }
}

$(document).ready(function(){
    $.fn.zTree.init($("#treeDemo"), setting, zNodes);
});

</script>
<body>
<div class="content_wrap">
    <div class="zTreeDemoBackground left">
        <ul id="treeDemo" class="ztree"></ul>
    </div>
</div>
</body>
</html>