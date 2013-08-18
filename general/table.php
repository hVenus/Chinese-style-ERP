<?php
include_once( "inc/auth.php" );
ob_end_clean( );
?>
<frameset rows="*"  cols="*" frameborder="NO" border="0" framespacing="0">
    <frame name="main" scrolling="auto" noresize src="mytable/intel_view?lc=<?php echo $i18n_COOKIE;?>" frameborder="0">
</frameset>
