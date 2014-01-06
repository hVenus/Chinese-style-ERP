<?php
/**
 * 连接数据库
 * @return type resource
 */
function OpenConnection( ){
    if ( !function_exists( "mysql_pconnect" ) ){
        echo _( "PHP配置有误，不能调用Mysql函数库，请检查有关配置" );
        exit( );
    }
    $C = @mysql_pconnect( MYSQL_DB_SERVER, DB_USER, DB_PASSWORD, MYSQL_CLIENT_COMPRESS );
    mysql_query( "SET NAMES utf8", $C );
    if ( !$C ){
        printerror( _( "不能连接到MySQL数据库，请检查：1、MySQL服务是否启动；2、MySQL被防火墙阻止；3、连接MySQL的用户名和密码是否正确。" ) );
        exit( );
    }
    $result = mysql_select_db( DB_NAME, $C );
    if ( !$result ){
        $TIPS = _( "数据库 %s 不存在" );
        printerror( sprintf( $TIPS, DB_NAME ) );
    }
    return $C;
}

function exequery( $C, $Q, $LOG = FALSE ){
    if ( !$LOG ){
        $POS = stripos( $Q, "union" );
        if ( $POS !== FALSE && stripos( $Q, "select", $POS ) !== FALSE ){
            exit( );
        }
        $POS = stripos( $Q, "into" );
        if ( $POS !== FALSE && ( stripos( $Q, "outfile", $POS ) !== FALSE || stripos( $Q, "dumpfile", $POS ) !== FALSE ) ){
            exit( );
        }
    }
    if ( gettype( $C ) != "resource" ){
        printerror( _( "无效的数据库连接" )."<br><b>"._( "SQL语句:" )."</b> ".$Q, $LOG );
        return FALSE;
    }
    $cursor = @mysql_query( $Q, $C );
    if ( !$cursor ){
        printerror( "<b>"._( "SQL语句:" )."</b> ".$Q, $LOG );
    }
    return $cursor;
}

function PrintError( $MSG, $LOG = FALSE ){
    global $SCRIPT_FILENAME;
    global $ROOT_PATH;
    echo "<fieldset style=\"line-height:150%;font-size:12px;\">";
    echo "<legend>&nbsp;请联系管理员&nbsp;</legend>";
    echo "<b>"._( "错误" )."#".mysql_errno( ).": </b> ".mysql_error( )."<br>";
    echo $MSG."<br>";
    echo "<b>"._( "文件：" )."</b>".$SCRIPT_FILENAME;
    if ( mysql_errno( ) == 1030 ){
        echo "<br>请联系管理员到 系统管理-数据库管理 中修复数据库解决。" ;
    }
    echo "</fieldset>";
    $LOG_PATH = realpath( $ROOT_PATH."../logs" );
    if ( $LOG ){
        if ( file_exists( $LOG_PATH ) && is_writable( $LOG_PATH ) ){
            $DATA = date( "[Y-m-d H:i:s]" )."\r\n";
            $DATA .=  "错误#" .mysql_errno( ).": ".mysql_error( )."\r\n";
            $DATA .= strip_tags( $MSG )."\r\n";
            $DATA .=  "文件：" .$SCRIPT_FILENAME."\r\n";
            $DATA .= "\r\n";
            $LOG_FILE = $LOG_PATH."/mysql_error.log";
            $FP = @fopen( $LOG_FILE, "a" );
            if ( $FP )
            {
                fwrite( $FP, $DATA );
                fclose( $FP );
            }
        }
        if ( $LOG ){
            exit( );
        }
    }
}

// =============================================================================
// 程序开始的地方
// 所有程序先加载本文件，本文件里执行的操作：
//   @数据库连接
//   @session
//   @注册自动加载类方法
// =============================================================================
require("setting.php");
require("autoload.php");
require("session.php");
if ( !$connection ){
    $connection = openconnection( );
}

// End file: conn.php
// Location: include/conn.php