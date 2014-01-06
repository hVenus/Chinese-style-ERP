<?php
include_once( "../../include/auth.php" );
include_once( "../../include/role.php" );
$menu1 = getMainMenuLevel1($_SESSION['LOGIN_USER_ID']);
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="<?php echo SITE_URL;?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="<?php echo SITE_URL;?>assets/js/jquery.min.js"></script>
</head>
<style>
        /*common style*/
    * { margin:0px; padding:0px; }
    body { font-size:16px; /*overflow-x:hidden;*/overflow-y:auto;margin: 0; padding: 0; }
    ul, li, p, h1, h2, h3, div, label, input, form { list-style:none; padding:0px; margin:0px; }
    .content {  margin:0 auto;  border-top:none;  }
    .toggle {  }
    .toggle dl dt {
        height:41px;
        line-height:41px;
        font-weight:bold;
        cursor:pointer;
        display:block;
        text-align: center;
        background: url("<?php echo SITE_URL;?>assets/images/menu001.png");
		font-size: 16px;
    }

    .toggle dl dt.current {  }
    .toggle dl dd { text-align: center;}
    .toggle dl dd span { display: block; }
    .toggle dl dd ul { }
    .toggle dl dd ul li { list-style:decimal inside none; }

    .menu {
        cursor: pointer;
		margin: 8px 0;
		font-size: 16px;
    }
    .menu:hover{
        background-color: #ffffff;
    }
    .hover{background-color: #ffffff;}
</style>

<script type="text/javascript">
    $(function(){
        $(".toggle dl dd").hide();
        $(".toggle dl dt").click(function(){
            $(".toggle dl dd").not($(this).next()).hide();
            $(".toggle dl dt").not($(this).next()).removeClass("current");
            $(this).next().slideToggle(250);
            $(this).toggleClass("current");
        });

        $('.menu').click(function() {

            //IF THE NEXT SLIDE WASN'T OPEN THEN OPEN IT
            var code = $(this).attr('code');
            var t =window.parent.parent.frames[2];
            if(code != "" && code != undefined && code != null){
                var s = code.substr(0, 1);
                if(s != '@'){
                    t.frames['main'].location="../../app/"+code+"?lc=<?php echo $i18n_COOKIE;?>&t=<?php echo time();?>";
                }
            }
        });

        $(".menu").hover(
            function() {
                $( this ).addClass( "hover" );
            }, function() {
                $( this ).removeClass( "hover" );
            }
        );
    });

</script>
<body>
<table width="100%" height="100%" bgcolor="#f9fbf9" cellspacing="0" cellpadding="0"  style="border-right: solid #d5d5d7 1px;">
    <tr>
        <td valign="top">
            <div class="content">
                <div class="toggle">
                    <dl>
                        <?php $i=1; if($menu1):?>
                            <?php foreach($menu1 as $m1):?>
                                <dt class="accordionButton" id="<?php echo $m1['MENU_ID']?>"><?php echo $m1['MENU_NAME']?></dt>
                                <?php $menu2 = getMainMenuLevel2($m1['MENU_ID'], $_SESSION['LOGIN_USER_ID']);?>
                                <?php if($menu2):?>
                                    <dd class="accordionContent">
                                        <?php foreach($menu2 as $m2):?>
                                            <?php $menu3 = getMainMenuLevel3($m2['MENU_ID'], $_SESSION['LOGIN_USER_ID']);?>
                                            <?php if($menu3):?>
                                                <?php foreach($menu3 as $m3):?>
                                                    <div class="menu" code="<?php echo $m3['FUNC_CODE']?>" id="<?php echo $m3['MENU_ID']?>">
                                                        <span><?php echo $m3['FUNC_NAME']?></span>
                                                    </div>
                                                <?php endforeach;?>
                                            <?php else:?>
                                                <div class="menu" code="<?php echo $m2['FUNC_CODE']?>" id="<?php echo $m2['MENU_ID']?>">
                                                    <span><?php echo $m2['FUNC_NAME']?></span>
                                                </div>
                                            <?php endif;?>
                                        <?php endforeach;?>
                                    </dd>
                                <?php endif;?>
                            <?php endforeach;?>
                        <?php endif;?>
                    </dl>
                </div>
            </div>
        </td>
    </tr>
</table>
</body>
</html>
