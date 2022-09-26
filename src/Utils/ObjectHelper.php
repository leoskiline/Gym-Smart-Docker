<?php

namespace App\Utils;

use ReflectionClass;

class ObjectHelper
{

    public static function dismount($obj) {
        if(is_object($obj))
        {
            $reflectionClass = new ReflectionClass(get_class($obj));
            $array = [];
            foreach ($reflectionClass->getProperties() as $property) {
                $property->setAccessible(true);
                $array[$property->getName()] = $property->getValue($obj);
                $property->setAccessible(false);
            }
            $obj = $array;
        }
        if(is_array($obj)) {
            $new = array();
            foreach($obj as $key => $val) {
                $new[$key] = self::dismount($val);
            }
        }
        else $new = $obj;
        return $new;
    }
}