<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script>
        if(typeof(sprintf) != "function"){
    function sprintf(str){
        var array = str.split("%s");
        if(array.length == 1 || array.length != arguments.length)
            return str;
        str = array[0];
        for(var i=1; i < array.length; i++){
            str += arguments[i] + array[i];
        }
        return str;
    }
}
    </script>
    <?php     echo $SCRIPT != "" ? "<script>\n".$SCRIPT."</script>" : "";?>
</head>
<body>
<?php if ( is_array( $MENU_HEAD ) ){?>
<div class="<?php echo $MENU_HEAD['class'] == "" ? "head" : $MENU_HEAD['class'];?>">
    <?php if ( $MENU_HEAD['img'] ){?>
    <img src="<?php echo $MENU_HEAD['img'];?>" align="absMiddle">
    <?php }?>
    <?php echo $MENU_HEAD['text'];?>
</div>
    <?php }?>

<ul>
    <?php $I = 0;?>
    <?php foreach ( $MENU_LEFT as $MENU ){ ++$I;?>
    <li>
        <a href="<?php echo $MENU['href'] == "" ? "javascript:;" : $MENU['href'];?>" onclick="<?php echo $MENU['onclick'] == "clickMenu" ? "clickMenu('".$I."');" : $MENU['onclick'];?>" target="<?php echo $MENU['target'] == "" ? "user_main" : $MENU['target'];?>" title="<?php echo $MENU['title'] == "" ? $MENU['text'] : $MENU['title'];?>" id="link_<?php echo $I;?>" <?php echo !$MENU['onclick'] && $MENU['module'] && !stristr( $MENU['module_style'], "display:none" ) ? " class=\"active\"" : "";?> >
            <span>
                <?php if ( $MENU['img'] != "" ){?>
                <img src="<?php echo $MENU['img'];?>" width="16" height="16" align="absmiddle">
                <?php }?>
                <?php echo $MENU['text'];?>
            </span>
        </a>
    </li>
    </ul>
    <?php
    if ( is_array( $MENU['module'] ) ){
        while ( list( $key, $value ) = each( $MENU['module'] ) ){
            $$key = $value;
        }
        ?>
        <div id="module_<?php echo $I;?>" class="moduleContainer treeList" style="<?php echo $MENU['module_style'];?>">
            <?php include_once( $include_file );?>
        </div>
        <?php }else if ( $MENU['module'] != "" ){?>
        <div id="module_<?php echo $I;?>" class="moduleContainer" style="<?php echo $MENU['module_style'];?>">
            <?php echo $MENU['module'];?>
        </div>
        <?php }
}
    ?>

<?php if ( $MENU_BOTTOM ){?>
<div id="MenuBottom"><?php echo $MENU_BOTTOM;?></div>
    <?php }?>
</body>
</html>