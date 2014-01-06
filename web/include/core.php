<?php
function Login( $USERNAME, $PASSWORD ){
    $return = false;
    
    global $connection;
    
    // 用户名不能为空
    if(trim($USERNAME)==""){
        $return = "用户名不能为空!";
    }else{
        // 用crypt验证密码
//        $sql = "SELECT * from USER where USER_ID='".$USERNAME."' ";
//        $cursor = exequery($connection, $sql);
//        if($ROW = mysql_fetch_array($cursor)){
//            $p = $ROW['PASSWORD'];
//        }
//        var_dump(crypt($PASSWORD, $p), $p);
        
        $md5 = md5($PASSWORD);
        $query = "SELECT * from USER where USER_ID='".$USERNAME."' AND PASSWORD='".$md5."' ";
        $cursor = exequery($connection, $query);
        if($ROW = mysql_fetch_array($cursor)){
            // 用户信息
            $UID = $ROW['UID'];
            $USER_ID = $ROW['USER_ID'];
            $BYNAME = $ROW['BYNAME'];
            $USER_NAME = $ROW['USER_NAME'];
            $BIND_IP = $ROW['BIND_IP'];
            $USEING_KEY = $ROW['USEING_KEY'];
            $SECURE_KEY_SN = $ROW['SECURE_KEY_SN'];
            $ON_STATUS = $ROW['ON_STATUS'];
            $LOGIN_USER_PRIV = $ROW['USER_PRIV'];
            $USER_PRIV_OTHER = $ROW['USER_PRIV_OTHER'];
            $LOGIN_AVATAR = $ROW['AVATAR'];
            $LOGIN_DEPT_ID = $ROW['DEPT_ID'];
            $LOGIN_DEPT_ID_OTHER = $ROW['DEPT_ID_OTHER'];
            $LAST_PASS_TIME = $ROW['LAST_PASS_TIME'];
            $LOGIN_THEME = $ROW['THEME'];
            $LOGIN_NOT_VIEW_USER = $ROW['NOT_VIEW_USER'];
            $LAST_VISIT_TIME = $ROW['LAST_VISIT_TIME'];
            $LOGIN_USER_EMAIL = $ROW['EMAIL'];
            
            // 再判断用户有没有被禁止登录
            $NOT_LOGIN = $ROW['NOT_LOGIN'];
            if($NOT_LOGIN){
                $return = "用户".$USERNAME."被设定为禁止登录！";
            }else{
                // 用户的权限
                if ( !find_id( $USER_PRIV_OTHER, $LOGIN_USER_PRIV ) ){
                    $USER_PRIV_OTHER .= $LOGIN_USER_PRIV.",";
                }

                $LOGIN_FUNC_STR = "";
                $USER_PRIV_OTHER = td_trim( $USER_PRIV_OTHER );
                if ( $USER_PRIV_OTHER != "" ){
                    $query1 = "SELECT FUNC_ID_STR from USER_PRIV where USER_PRIV in (".$USER_PRIV_OTHER.")";
                    $cursor1 = exequery( $connection, $query1 );
                    while ( $ROW = mysql_fetch_array( $cursor1 ) ){
                        $FUNC_STR = $ROW['FUNC_ID_STR'];
                        $MY_ARRAY = explode( ",", $FUNC_STR );
                        $ARRAY_COUNT = sizeof( $MY_ARRAY );
                        // 数组的最后一个是空的，所以去掉。
                        if ( $MY_ARRAY[$ARRAY_COUNT - 1] == "" ){
                            $ARRAY_COUNT--;
                        }

                        for ( $I=0; $I<$ARRAY_COUNT; $I++){
                            if ( !find_id( $LOGIN_FUNC_STR, $MY_ARRAY[$I] ) ){
                                $LOGIN_FUNC_STR .= $MY_ARRAY[$I].",";
                            }
                        }
                    }
                }
                
                // 用户信息写到session里。
                $LOGIN_UID = $UID;
                $LOGIN_USER_ID = $USER_ID;
                $LOGIN_BYNAME = $BYNAME;
                $LOGIN_USER_NAME = $USER_NAME;
                $LOGIN_ANOTHER = "0";
                $LOGIN_USER_PRIV_OTHER = $USER_PRIV_OTHER;
                $_SESSION['LOGIN_UID'] = $LOGIN_UID;
                $_SESSION['LOGIN_USER_ID'] = $LOGIN_USER_ID;
                $_SESSION['LOGIN_BYNAME'] = $LOGIN_BYNAME;
                $_SESSION['LOGIN_USER_NAME'] = $LOGIN_USER_NAME;
                $_SESSION['LOGIN_USER_PRIV'] = $LOGIN_USER_PRIV;
                $_SESSION['LOGIN_USER_PRIV_OTHER'] = $LOGIN_USER_PRIV_OTHER;
                $_SESSION['LOGIN_DEPT_ID'] = $LOGIN_DEPT_ID;
                $_SESSION['LOGIN_DEPT_ID_OTHER'] = $LOGIN_DEPT_ID_OTHER;
                $_SESSION['LOGIN_AVATAR'] = $LOGIN_AVATAR;
                $_SESSION['LOGIN_THEME'] = $LOGIN_THEME;
                $_SESSION['LOGIN_FUNC_STR'] = $LOGIN_FUNC_STR;
                $_SESSION['LOGIN_NOT_VIEW_USER'] = $LOGIN_NOT_VIEW_USER;
                $_SESSION['LOGIN_ANOTHER'] = $LOGIN_ANOTHER;

                // 更新user表里的最后登录时间
                if ( $SEC_ON_STATUS != "1" && $ON_STATUS != "1" ){
                    $update_str .= ",ON_STATUS='1'";
                }
                $query = "update USER set LAST_VISIT_TIME='".date( "Y-m-d H:i:s" )."'".$update_str.( " where USER_ID='".$LOGIN_USER_ID."'" );
                exequery( $connection, $query );

                add_log( 1, "", $LOGIN_USER_ID );

                $return = "1";
            }     
        }else{
            $ERROR_PWD = maskstr($PASSWORD, 2, 1);
            add_log(2, $ERROR_PWD, $USERNAME);
            $return = "用户名或密码错误，注意大小写!";
        }
    }
    
    return $return;
}


function maskstr( $STR, $FIRST, $LAST ){
    $return = "";
    if ( !is_numeric( $FIRST ) || !is_numeric( $LAST ) ){
    }else if ( strlen( $STR ) <= $FIRST + $LAST ){
        $return = $STR;
    }else{
        $RETURN_STR = substr( $STR, 0, $FIRST );
        for ( $I = 0; $I<strlen(substr($STR, $FIRST, 0 - $LAST ) );$I++){
            $RETURN_STR .= "*";
        }
        $RETURN_STR .= substr( $STR, 0 - $LAST );
        $return = $RETURN_STR;
    }
    return $return;
}


// End file: core.php
// Location: include/core.php