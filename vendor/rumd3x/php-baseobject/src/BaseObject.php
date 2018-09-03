<?php
namespace Rumd3x\BaseObject;

use StdClass;
use Exception;
use ReflectionClass;
use Rumd3x\BaseObject\Traits\StringHelpers;
use Rumd3x\BaseObject\Exceptions\MethodNotFoundException;

class BaseObject extends StdClass {
    use StringHelpers;

    public function __call($method, $arguments) {
        $firstThree = substr($method, 0, 3);
        if ($firstThree === 'get' || $firstThree === 'set') {
            $rest = $this->toSnakeCase(substr($method, 3));
            if ($firstThree === 'get') {
                if (property_exists($this, $rest)) {
                    $retorno = $rest;
                } else {
                    $retorno = NULL;
                }
            } else {
                $this->$rest = $arguments[0];
                $retorno = $this;
            }
        } else {
            $classname = get_class($this);
            $args_string_arr = [];
            foreach($arguments as $arg) {
                $args_string_arr[] = var_export($arg, true);
            }
            $args_string = implode(', ', $args_string_arr);
            throw new MethodNotFoundException($this, "Method {$method}({$args_string}) does not exist on class {$classname}");
        }
        return $retorno;
    }

    public static function parse($data) {
        $instance = isset($this) ? $this : (new static);
        if (is_array($data) || is_object($data)) {
            foreach($data as $key => $value) {
                $instance->$key = $value;
            }
        } else {
            if (self::isJson($data)) {
                $data = json_decode($data, true);
                if (is_array($data)) {
                    foreach($data as $key => $value) {
                        $instance->$key = $value;
                    }
                }
            } elseif (self::hasXml($data)) {
                try {
                    $xml = new \SimpleXMLElement($data);
                    $json = json_encode($xml);
                    $data = json_decode($json,TRUE);
                    if (is_array($data)) {
                        foreach($data as $key => $value) {
                            $instance->$key = $value;
                        }
                    }
                } catch (Exception $e) {
                    // Not a XML
                }
            }
        }
        return $instance;
    }
    
    public function __get($prop) {
        $getter = 'get'.ucfirst($this->toCamelCase($prop));
        return $this->{$getter}();
    }

    public function __set($prop, $value) {
        $setter = 'set'.ucfirst($this->toCamelCase($prop));
        return $this->{$setter}($value);
    }

    public function toArray($object = NULL) {
        if (!is_array($object)) {
            $vars = empty($object) ? get_object_vars($this) : get_object_vars($object);
        } else {
            $vars = $object;
        }
        $result = [];
        foreach($vars as $key => $var) {
            if (is_object($var) || is_array($var)) {
                $var = $this->toArray($var);
            }
            $result[$key] = $var;
        }
        return $result;
    }

    public function toJson($pretty = false) {
        $options = JSON_UNESCAPED_SLASHES;
        $options |= JSON_UNESCAPED_UNICODE;
        $options |= JSON_NUMERIC_CHECK;
        $options |= JSON_PARTIAL_OUTPUT_ON_ERROR;
        $options |= JSON_PRESERVE_ZERO_FRACTION; 

        if ($pretty) {
            $options |= JSON_PRETTY_PRINT;
        }

        return json_encode($this->toArray(), $options);
    }

    public function toXml($pretty = false, $array = NULL, $depth = 0) {
        $return = "";
        $end_line = $pretty ? PHP_EOL : '';
        $tabs = $pretty ? str_repeat("\t", $depth) : '';
        if (is_null($array)) $class = (new ReflectionClass($this))->getShortName();
        if (is_null($array)) $return = "<?xml version=\"1.0\"?>{$end_line}";
        if (is_null($array)) $array = [$class => $this->toArray()];
        foreach($array as $key => $value) {
            if (is_numeric($key)) {
                $key = 'item'.$key;
            } else {
                $key = $this->toCamelCase($key);
            }
            if (is_array($value)) {
                $return .= "{$tabs}<{$key}>{$end_line}";
                $return .= $this->toXml($pretty, $value, $depth+1);
                $return .= "{$tabs}</{$key}>{$end_line}";
            } else {
                if (!is_null($value)) {
                    $return .= "{$tabs}<{$key}>{$value}</{$key}>{$end_line}";
                } else {
                    $return .= "{$tabs}<{$key}/>{$end_line}";
                }
            }
        }
        return $return;
    }

    public function __toString() {
        return $this->toJson();
    }

}