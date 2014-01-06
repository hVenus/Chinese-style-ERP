<?php

class CheckType {

    public static function is_number($str) {
        if (substr($str, 0, 1) == "-") {
            $str = substr($str, 1);
        }
        $length = strlen($str);
        for ($i = 0; $i < $length; ++$i) {
            $ascii_value = ord(substr($str, $i, 1));
            if (48 <= $ascii_value && $ascii_value <= 57) {
                continue;
            }
            return FALSE;
        }
        if ($str != "0") {
            $str = intval($str);
            if ($str == 0) {
                return FALSE;
            }
        }
        return TRUE;
    }

    public static function is_decimal($str) {
        if (substr($str, 0, 1) == "-") {
            $str = substr($str, 1);
        }
        $length = strlen($str);
        $i = 0;
        for (; $i < $length; ++$i) {
            $ascii_value = ord(substr($str, $i, 1));
            if (0 < $i && $ascii_value == 46 || 48 <= $ascii_value && $ascii_value <= 57) {
                continue;
            }
            return FALSE;
        }
        return TRUE;
    }

    public static function is_money($str) {
        $dot_pos = strpos($str, ".");
        if (!$dot_pos) {
            return FALSE;
        }
        $str1 = substr($str, 0, $dot_pos);
        if (14 < strlen($str1)) {
            return FALSE;
        }
        if (!is_number($str1)) {
            return FALSE;
        }
        $str2 = substr($str, $dot_pos + 1, strlen($str) - $dot_pos);
        if (strlen($str2) != 2) {
            return FALSE;
        }
        if (!is_number($str2)) {
            return FALSE;
        }
        return TRUE;
    }

    public static function is_money_len($str, $int_len, $dot_len) {
        $dot_pos = strpos($str, ".");
        if (!$dot_pos) {
            return FALSE;
        }
        $str1 = substr($str, 0, $dot_pos);
        if ($int_len < strlen($str1)) {
            return FALSE;
        }
        if (!is_number($str1)) {
            return FALSE;
        }
        $str2 = substr($str, $dot_pos + 1, strlen($str) - $dot_pos);
        if (strlen($str2) != $dot_len) {
            return FALSE;
        }
        if (!is_number($str2)) {
            return FALSE;
        }
        return TRUE;
    }

    public static function is_date($str) {
        $YEAR = "";
        $MONTH = "";
        $DAY = "";
        $len = strlen($str);
        $offset = 0;
        $i = strpos($str, "-", $offset);
        $YEAR = substr($str, $offset, $i - $offset);
        $offset = $i + 1;
        if ($len < $offset) {
            return FALSE;
        }
        if ($i) {
            $i = strpos($str, "-", $offset);
            $MONTH = substr($str, $offset, $i - $offset);
            $offset = $i + 1;
            if ($len < $offset) {
                return FALSE;
            }
            if ($i) {
                $DAY = substr($str, $offset, $len - $offset);
            }
        }
        if ($YEAR == "" || $MONTH == "" || $DAY == "") {
            return FALSE;
        }
        if (!checkdate(intval($MONTH), intval($DAY), intval($YEAR))) {
            return FALSE;
        }
        return TRUE;
    }

    public static function is_time($str) {
        $TEMP = "";
        $HOUR = "";
        $MIN = "";
        $SEC = "";
        $TEMP = strtok($str, ":");
        $HOUR = $TEMP;
        if ($HOUR == "" || 24 <= $HOUR || $HOUR < 0 || !is_number($HOUR)) {
            return FALSE;
        }
        $TEMP = strtok(":");
        $MIN = $TEMP;
        if ($MIN == "" || 60 <= $MIN || $MIN < 0 || !is_number($MIN)) {
            return FALSE;
        }
        $TEMP = strtok(":");
        $SEC = $TEMP;
        if ($SEC == "" || 60 <= $SEC || $SEC < 0 || !is_number($SEC)) {
            return FALSE;
        }
        return TRUE;
    }

    public static function is_date_time($DATE_TIME_STR) {
        if ($DATE_TIME_STR == NULL || strlen($DATE_TIME_STR) == 0) {
            return FALSE;
        }
        $DATE_TIME_ARRY = explode(" ", $DATE_TIME_STR);
        if (is_date($DATE_TIME_ARRY[0]) && is_time($DATE_TIME_ARRY[1])) {
            return TRUE;
        }
        return FALSE;
    }

}
