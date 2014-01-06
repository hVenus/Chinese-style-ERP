<?php
global $SYS_FUNCTION;
global $LANG_COOKIE;
if ( !is_array( $SYS_FUNCTION ) || count( $SYS_FUNCTION ) == 0 || !is_array( $SYS_FUNCTION[0] ) ){
    $cache = new Cache();
    $SYS_FUNCTION = $cache->get( "SYS_FUNCTION_ALL_".bin2hex( $LANG_COOKIE ) );
    if ( !is_array( $SYS_FUNCTION ) ){
        cacheMenu( );
        $SYS_FUNCTION = $cache->get( "SYS_FUNCTION_ALL_".bin2hex( $LANG_COOKIE ) );
    }
}