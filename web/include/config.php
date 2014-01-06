<?
//-- 网页根目录配置(Apache:自动获取) --
$ROOT_PATH=getenv("DOCUMENT_ROOT");

if($ROOT_PATH=="")
    $ROOT_PATH="D:/OA/webroot/";

if(substr($ROOT_PATH,-1)!="/")
    $ROOT_PATH.="/";

//-- 数据库配置 --//
$MYSQL_SERVER="127.0.0.1:9528";
$MYSQL_USER="root";
$MYSQL_DB="td_oa";
$MYSQL_PASS="myoa888";


// =============================================================================


//** 新版设置 **//

$SITE_URL = "http://127.0.0.1:8080/ao/"; // 网站的地址

$DB_HOST="127.0.0.1";
$DB_PORT="9528";
$DB_USER="root";
$DB_PASSWORD="myoa888";
$DB_NAME="td_oa";
$DB_DRIVER="mysql";

//-- memcache --//;
$MEMCACHED_HOST = '127.0.0.1';
$MEMCACHED_PORT = '11911';

//-- session --//
// 支持 files,user,memcache 三种方式，为memcache时需设置$SESSION_SAVE_PATH为memcache的地址
// 目前只支持memcache方式
$SESSION_SAVE_HANDLER = 'memcache';
$SESSION_SAVE_PATH = $MEMCACHED_HOST.':'.$MEMCACHED_PORT;

//-- 数据缓存方式，默认为memcache
$CACHE_DRIVER = 'memcache';
$CACHE_CONFIG = array(
    'default' => array(
        'default_host'		=> $MEMCACHED_HOST,
        'default_port'		=> $MEMCACHED_PORT,
        'default_persistent' => true,
        'default_weight'	=> 1
    )
);

//** 此区域外的需要删除 **//
