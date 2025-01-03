<?php
if ( !defined('ROOT') )
    define('ROOT', __DIR__ . "/..");
require_once ROOT . "/private/common.php";

class RequestError extends Exception { }

// *** should implement getters for data structures

// $reqparams must be an array from the request. for example $_GET
abstract class Request {
    static function getVal($reqparams, $name) {
        if ( isset($reqparams[$name]) && $reqparams[$name] !== "" ) {
            if ( is_array($reqparams[$name]) )
                throw new RequestError($name . " is an array.");
            return $reqparams[$name];
        } else
            return null;
    }

    static function getMandatoryVal($reqparams, $name) {
        $result = self::getVal($reqparams, $name);
        if ( $result === null )
            throw new RequestError("Missing " . $name . ".");
        return $result;
    }

    static function getStr($reqparams, $name, $maxlen = null, $multiline = false) {
        $result = self::getVal($reqparams, $name);
        if ( $result !== null )
            self::prepareString($result, $maxlen, $name, $multiline);
        return $result;
    }

    static function getMandatoryStr($reqparams, $name, $maxlen = null, $multiline = false) {
        $result = self::getMandatoryVal($reqparams, $name);
        self::prepareString($result, $maxlen, $name, $multiline);
        return $result;
    }

    // $format can be a single format or an array of formats of which the first matching will be used
    static function getDate($reqparams, $name, $format = "!Y. m. d.") {
        if ( !is_array($format) )
            $format = [$format];
        $val = self::getStr($reqparams, $name);
        if ( $val === null )
            return null;
        foreach ( $format as $formatstr ) {
            $result = myDateCreateFromFormat($formatstr, $val);
            if ( $result !== false )
                return $result;
        }
        throw new RequestError($name . " contains invalid date.");
    }

    static function getMandatoryDate($reqparams, $name, $format = "!Y. m. d.") {
        $result = self::getDate($reqparams, $name, $format);
        if ( $result === null )
            throw new RequestError("Missing " . $name . ".");
        return $result;
    }

    static function parseInt($val, $name, $min = null, $max = null) {
        // int array keys are automatically cast to int by PHP, so they don't need to be parsed
        if ( !is_int($val) ) {
            if ( is_array($val) )
                throw new RequestError($name . " is an array.");
            $result = (int)$val;
            if ( (string)$result !== $val )
                throw new RequestError($name . " contains invalid int: " . $val);
        } else
            $result = $val;
        if ( $min !== null && $result < $min )
            throw new RequestError($name . " too small: " . $val);
        if ( $max !== null && $result > $max )
            throw new RequestError($name . " too big: " . $val);
        return $result;
    }

    static function getInt($reqparams, $name, $min = null, $max = null) {
        $result = self::getVal($reqparams, $name);
        if ( $result !== null )
            $result = self::parseInt($result, $name, $min, $max);
        return $result;
    }

    static function getMandatoryInt($reqparams, $name, $min = null, $max = null) {
        $result = self::getInt($reqparams, $name, $min, $max);
        if ( $result === null )
            throw new RequestError("Missing " . $name . ".");
        return $result;
    }

    static function getEnum($reqparams, $name, $values) {
        $result = self::getVal($reqparams, $name);
        if ( $result !== null && !in_array($result, $values, true) )
            throw new RequestError("Invalid " . $name . " value: " . $result . ".");
        return $result;
    }

    static function getMandatoryEnum($reqparams, $name, $values) {
        $result = self::getEnum($reqparams, $name, $values);
        if ( $result === null )
            throw new RequestError("Missing " . $name . ".");
        return $result;
    }

    static function isBool($reqparams, $name) {
        return ( !isset($reqparams[$name]) || !is_array($reqparams[$name]) );
    }

    // for form controls "false" values are indicated by not sending the parameter, so it's not possible
    // to differentiate between false and null, thus no _mandatory version of this function
    static function getBool($reqparams, $name) {
        if ( !isset($reqparams[$name]) )
            return false;
        if ( is_array($reqparams[$name]) )
            throw new RequestError($name . " is not a bool.");
        $UC_FALSE_VALUES = ["", "0", "FALSE", "OFF"];
        return !in_array(strtoupper($reqparams[$name]), $UC_FALSE_VALUES, true);
    }

    // accepts any type of array
    static function getArray($reqparams, $name) {
        if ( isset($reqparams[$name]) && $reqparams[$name] !== "" ) {
            if ( !is_array($reqparams[$name]) )
                throw new RequestError($name . " is not an array.");
            return $reqparams[$name];
        } else
            return array();
    }

    static function getStrList($reqparams, $name, $strmaxlen = null, $multiline = false,
                               $maxlen = null) {
        $valFormatFunc = function($reqparams, $name) use ($strmaxlen, $multiline) {
            return Request::getStr($reqparams, $name, $strmaxlen, $multiline);
        };
        return self::getList($reqparams, $name, $maxlen, $valFormatFunc);
    }

    static function getMandatoryStrList($reqparams, $name, $strmaxlen = null, $multiline = false,
                                        $maxlen = null) {
        $valFormatFunc = function($reqparams, $name) use ($strmaxlen, $multiline) {
            return Request::getMandatoryStr($reqparams, $name, $strmaxlen, $multiline);
        };
        return self::getList($reqparams, $name, $maxlen, $valFormatFunc);
    }

    static function getMandatoryDateList($reqparams, $name, $format = "!Y. m. d.", $maxlen = null) {
        $valFormatFunc = function($reqparams, $name) use ($format) {
            return Request::getMandatoryDate($reqparams, $name, $format);
        };
        return self::getList($reqparams, $name, $maxlen, $valFormatFunc);
    }

    static function getIntList($reqparams, $name, $min = null, $max = null, $maxlen = null) {
        $valFormatFunc = function($list, $name) use ($min, $max) {
            return Request::getInt($list, $name, $min, $max);
        };
        return self::getList($reqparams, $name, $maxlen, $valFormatFunc);
    }

    static function getMandatoryIntList($reqparams, $name, $min = null, $max = null,
                                           $maxlen = null) {
        $valFormatFunc = function($list, $name) use ($min, $max) {
            return Request::getMandatoryInt($list, $name, $min, $max);
        };
        return self::getList($reqparams, $name, $maxlen, $valFormatFunc);
    }

    // this doesn't work with lists of checkboxes, as they only send their values when checked, so false
    // values won't be sent.
    static function getBoolList($reqparams, $name, $maxlen = null) {
        return self::getList($reqparams, $name, $maxlen, 'Request::getBool');
    }

    // accepts a plain (numeric) array. all of its elements must also be arrays of any type.
    static function getRows($reqparams, $name) {
        $result = self::getArray($reqparams, $name);
        $expKey = 0;
        foreach ( $result as $key=>$row ) {
            if ( $key !== $expKey || !is_array($row) )
                throw new RequestError($name . " has wrong format.");
            ++$expKey;
        }
        return $result;
    }

    // same as getRows, but the array musn't be a numeric array, it can have any keys for the rows.
    static function getKeyedRows($reqparams, $name) {
        $result = self::getArray($reqparams, $name);
        foreach ( $result as $row )
            if ( !is_array($row) )
                throw new RequestError($name . " has wrong format.");
        return $result;
    }


    private static function getList($reqparams, $name, $maxlen, $valFormatFunc = null) {
        $result = self::getArray($reqparams, $name);
        $expKey = 0;
        foreach ( $result as $key=>&$val ) {
            if ( $maxlen !== null && $expKey >= $maxlen )
                throw new RequestError($name . " is too long.");
            if ( $key !== $expKey || is_array($val) )
                throw new RequestError($name . " has wrong format.");
            if ( $valFormatFunc !==  null)
                $val = $valFormatFunc($result, $key);
            ++$expKey;
        }
        unset($val);
        return $result;
    }

    private static function prepareString(&$str, $maxlen, $name, $multiline) {
        if ( !mb_check_encoding($str) )
            throw new RequestError($name . " has invalid encoding.");
        $pattern = ($multiline ? '/[\h]+/u' : '/[\s]+/u');
        $str = trim(preg_replace($pattern, ' ', $str));
        if ( $multiline )
            $str = preg_replace('/(?: (?=\v)|(?<=\v) )/u', '', $str);
        if ( $maxlen !== null && mb_strlen($str) > $maxlen )
            throw new RequestError($name . " is too long.");
    }
}

?>
