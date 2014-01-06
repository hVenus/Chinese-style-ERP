<?php
defined('DS') ? null : define('DS',DIRECTORY_SEPARATOR);

$ROOT_PATH = getenv( "DOCUMENT_ROOT" );
if ( $ROOT_PATH == "" ){
    $ROOT_PATH = "d:/AO/webroot/";
}
if ( substr( $ROOT_PATH, -1 ) != "/" ){
    $ROOT_PATH .= "/";
}
$ATTACH_PATH = $ROOT_PATH."attachment/";
$ATTACH_PATH2 = realpath( $ROOT_PATH."../" )."/attach/";
$ATTACH_BACKUP_PATH = $ATTACH_PATH2."bak/";
$BACKUP_PATH = realpath( $ROOT_PATH."../" )."/bak/";
$SMS_REF_SEC = 30;
$ONLINE_REF_SEC = 120;
$ATTACH_LOCK_REF_SEC = 180;
$OFFLINE_TIME_MIN = 0;
$STATUS_REF_SEC = 3600;
$SMS_REF_MAX = 3;
$SMS_CALLSOUND_INTERVAL = 3;
$FLOW_REMIND_TIME = 0;
$UPLOAD_FORBIDDEN_TYPE = "php,php3,php4,php5,phpt,jsp,asp,aspx,";
$UPLOAD_LIMIT = 1;
$UPLOAD_LIMIT_TYPE = "php,php3,php4,php5,";
$EDIT_LIMIT_TYPE = "php,php3,php4,php5,phpt,inc,jsp,asp,aspx,js,cgi,pl,";
$CORRECT_BUTTON = 1;
$IASK_YN = 1;
$ONE_USER_MUL_LOGIN = 1;
$ATTACH_UTF8 = 0;
$ATTACH_OFFICE_OPEN_IN_IE = 0;
$SMS_DELAY_PER_ROWS = 60;
$SMS_DELAY_SECONDS = 60;
$MYSQL_SERVER = "localhost:3336";
$MYSQL_USER = "root";
$MYSQL_DB = "TD_OA";
$MYSQL_PASS = "myoa888";
$i18n_COOKIE = $_COOKIE['i18n_COOKIE']!=''?$_COOKIE['i18n_COOKIE']:'zh_CN';// 用于多语言

/* 确定需要保留的设置 */

// 系统默认语言
$IS_UN = 0;
$DEFAULT_LANG = "zh-CN";
$LANG_COOKIE = $IS_UN && $_COOKIE['LANG_COOKIE'] != "" ? $_COOKIE['LANG_COOKIE'] : $DEFAULT_LANG;

// memcache default setting
$MEMCACHED_HOST = "127.0.0.1";
$MEMCACHED_IP = "11211";

// session default setting
// default use file store sesion data.
$SESSION_SAVE_HANDLER = "file";
// for memcache
$SESSION_SAVE_PATH = "tcp://".$MEMCACHED_HOST.":".$MEMCACHED_PORT."?persistent=0";


// 此处加载config.php将覆盖默认设置。
require( "config.php" );
/* 非此区域内的设置都可以删除 */

$UPLOAD_FORBIDDEN_TYPE = strtolower( $UPLOAD_FORBIDDEN_TYPE );
$UPLOAD_LIMIT_TYPE = strtolower( $UPLOAD_LIMIT_TYPE );
$EDIT_LIMIT_TYPE = strtolower( $EDIT_LIMIT_TYPE );
if ( !extension_loaded( "gettext" ) ){
    if ( !function_exists( "_" ) ){
        function _( $msg ){
            return $msg;
        }
    }
}else{
    putenv( "LANG=".$i18n_COOKIE );
    setlocale( LC_ALL, $i18n_COOKIE );
    $LANG_DOMAIN = $i18n_COOKIE;
    bindtextdomain( $LANG_DOMAIN, $ROOT_PATH."lang" );
    bind_textdomain_codeset( $LANG_DOMAIN, "UTF-8" );
    textdomain( $LANG_DOMAIN );
}

// ============================================================================
// 定义常量
//
defined("SITE_URL")?null:define("SITE_URL", $SITE_URL);

defined('ROOT_PATH')?null:define('ROOT_PATH', $ROOT_PATH);
//defined('LIBRARY_PATH')?null:define("LIBRARY_PATH", ROOT_PATH."library/");
defined('LIBRARY_PATH')?null:define("LIBRARY_PATH", ROOT_PATH."WEB-INF/classes/");

defined('DB_DRIVER')?null:define('DB_DRIVER', $DB_DRIVER);
defined('DB_HOST')?null:define('DB_HOST', $DB_HOST);
defined('DB_PORT')?null:define('DB_PORT', $DB_PORT);
defined('DB_USER')?null:define('DB_USER', $DB_USER);
defined('DB_PASSWORD')?null:define('DB_PASSWORD', $DB_PASSWORD);
defined('DB_NAME')?null:define('DB_NAME', $DB_NAME);
defined('MYSQL_DB_SERVER')?null:define('MYSQL_DB_SERVER', DB_HOST.":".DB_PORT);

// seesion
defined('SESSION_SAVE_HANDLER')?null:define('SESSION_SAVE_HANDLER', $SESSION_SAVE_HANDLER);
defined('SESSION_SAVE_PATH')?null:define('SESSION_SAVE_PATH', $SESSION_SAVE_PATH);

// cache 
defined('CACHE_DRIVER')?null:define('CACHE_DRIVER', $CACHE_DRIVER);

defined("DEFAULT_LANG")?null:define("DEFAULT_LANG", $DEFAULT_LANG);

// End file: setting.php
// Location: include/setting.php