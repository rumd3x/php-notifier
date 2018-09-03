<?php
namespace Rumd3x\BaseObject\Traits;

trait StringHelpers {

    private static function toCamelCase($string) {
        $camel_cased = preg_replace_callback('/(^|_)([a-z])/', function($m) {
            return strtoupper($m[2]);
        }, strval($string));

        return lcfirst($camel_cased);
    }

    private static function toSnakeCase($string) {
        $snake_cased = preg_replace_callback('/(^|[a-z])([A-Z])/', function($m) {
            return strtolower(strlen($m[1]) ? $m[1]."_".$m[2] : $m[2]);
        }, strval($string));
        
        return $snake_cased;
    }

    private static function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    private static function hasXml($string) {
        return ($string != strip_tags($string));
    }
}