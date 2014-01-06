<?php
require( "auth.php" );
if ( strtolower( $dataType ) == "javascript" ){
    $JS_ARRAY = "";
    foreach ( $MENU_TOP as $MENU ){
        $JS_ARRAY .= "{text:\"".htmlspecialchars( $MENU['text'] )."\",title:\"".htmlspecialchars( $MENU['title'] )."\",href:\"".str_replace( "\"", "\\\"", $MENU['href'] )."\",active:\"".$MENU['active']."\"},";
    }
    echo "[".str_replace( array( "\r", "\n" ), array( "", "" ), td_trim( $JS_ARRAY ) )."]";
    exit( );
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="<?php echo SITE_URL;?>assets/css/menu_top.css" />
    <script language="JavaScript" src="<?php echo SITE_URL;?>assets/js/menu_top.js"></script>
    <?php echo $SCRIPT;?>
</head>
<body>
<div id="navPanel">  
    <div id="navMenu" style="width:auto;">
    <?php foreach ( $MENU_TOP as $MENU ){?>
        <a href="<?php echo $MENU['href'];?>" target="<?php echo $MENU['target'] == "" ? "menu_main" : $MENU['target'];?>" title="<?php echo $MENU['title'] == "" ? htmlspecialchars( $MENU['text'] ) : htmlspecialchars( $MENU['title'] );?>" hidefocus="hidefocus">
            <span>
            <?php if ( $MENU['closeable'] == 1 ){?>
                <span class="close"></span>
            <?php }?>
            <?php if ( $MENU['img'] != "" ){?>
            <img style="height:16px;" src="<?php echo SITE_URL;?>assets<?php echo $MENU['img'];?>" align="absmiddle" />
            <?php }?>
            <?php echo htmlspecialchars( $MENU['text'] );?>
            </span>
        </a>
    <?php }?>
    </div>  
    <div id="navRight" style="float:left;">    
        <img id="navScroll" src="<?php echo SITE_URL;?>assets/images/nav_r1.gif" style="display:none;cursor:pointer;" align="absMiddle" title="<?php echo _( "显示下一行" );?>" />
        <?php echo $MENU_RIGHT;?>
    </div>
</div>
</body>
</html>